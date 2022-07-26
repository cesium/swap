<?php

namespace App\Http\Controllers;

use App\Judite\Models\Exchange;
use Illuminate\Support\Facades\DB;
use App\Events\ExchangeWasDeclined;
use App\Events\ExchangeWasConfirmed;
use Illuminate\Support\Facades\Auth;

class ConditionalExchangeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can.student');
        $this->middleware('student.verified');
        $this->middleware('can.exchange');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create($id)
	{
        try {
            $data = DB::transaction(function () use ($id) {
                $student = Auth::student()->findOrFail($id);
                $courseEnrollments = $student->getCourseEnrollments();
                return compact('courseEnrollments','student');
                }
            );
        
            $data['courseEnrollments']=array_map(function($course){ $course['matchingShifts']= $course['matchingShifts'] ->map(function ($item) {
                return [
                    'tag' => $item->tag,
                    '_toString' => $item->present()->inlineToString(),
                ];
            });return $course;},$data['courseEnrollments']
            );
            return view('conditionalExchanges.create',$data);
        } catch (\LogicException $e) {
			flash($e->getMessage())->error();
            return redirect()->route('dashboard');
        }
    }

    public function store($id, CreateRequest $request)
	{
        try {
            $conditionalExchange = DB::transaction(function () use ($id, $request) {
                $student = Auth::student()->findOrFail($id);
                $courseEnrollments = $student->hasMany(Enrollment::Class);
                $conditionalExchange = NULL;
            foreach($courseEnrollments as $fromEnrollment){
                $course = $fromEnrollment->course()->first();
                $toShift = $course->getShiftByTag($request->input(str_replace(" ","",$course->name)));
                if ($toShift != null){
                    if($conditionalExchange===NULL){
                        $conditionalExchange = ConditionalExchange::make();
                    }
                    $toEnrollment = Enrollment::make();
                    $toEnrollment->student()->associate(null);
                    $toEnrollment->course()->associate($course);
                    $toEnrollment->shift()->associate($toShift);
                                   $toEnrollment->save();
                }
				$exchange = Exchange::make();
				$exchange->setExchangeEnrollments($fromEnrollment, $toEnrollment);
				$exchange->save();
                $conditionalExchange->associate($exchange);
            }
                $conditionalExchange->save();
                return $conditionalExchange;
            });
            DB::beginTransaction();
	    $message = 'The exchange was successfully saved';
	    flash($message)->success();
            Solver::SolveConditionalExchanges();
            DB::commit();

        } catch (EnrollmentCannotBeExchangedException | ExchangeEnrollmentsOnDifferentCoursesException $e) {
            flash($e->getMessage())->error();
        }

	    return redirect()->route('dashboard');
    }

}