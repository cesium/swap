<?php

namespace App\Judite\Models;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class solver extends Model
{
	/**
	 * changes the exchange format to the one used by the solver
	 *
	 * @param Course								$course
	 */
	public static function SolveAutomicExchangesOfCourse(Course $course)
	{
		$url = 'http://10.0.0.2:4567/';
		$request = collect(['exchange_requests'=>Solver::changeExchangeToSolverType($course->automaticExchanges())]);

		$response = Http::post($url,$request->toJson());
		if (!$response->successful()) {
			echo "error";
		}
		$exchanges_ids = json_decode($request->JSON(), true);
		Exchange::FindMany($exchanges_ids)->each()->perform();
        return $exchanges_ids;
	}

	/**
	 * changes the exchange format to the one used by the solver
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return array
	 */
	private static function changeExchangeToSolverType($query){
        $values = [];
        foreach($query as $exchange){
            $values[] = array(
                'id' => $exchange->id,
                'from_shift_id' => $exchange->fromEnrollment()->shift()->id,
                'to_shift_id' => $exchange->toEnrollment()->shift()->id,
                'created_at' => $exchange->updated_at
            );

    }
        return $values;
	}


}
