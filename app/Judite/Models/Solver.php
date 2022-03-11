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
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param Course								$course
	 */
	public function SolveAutomicExchangesOfCourse($query,Course $course)
	{
		$url = 'http://0.0.0.0:4567/';
		$request = collect(['exchange_requests'=>changeExchangeToSolverType($course->automaticExchanges())]);

		$response = Http::post($url,$request->toJson());
		if (!$response->successful()) {
			echo "error";
		}
		$exchanges_ids = json_decode($request->JSON(), true);
		$query->whereIn('id',$exchanges_ids)->each()->perform();
	}

	/**
	 * changes the exchange format to the one used by the solver
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	private function changeExchangeToSolverType($query){
		return $query->map(function ($exchange){
			return array(
				'id'=>$exchange->id,
				'from_shift_id'=> $exchange->fromEnrollment()->shift->id,
				'to_shift_id'=> $exchange-toEnrollment()->shift->id ,
				'created_at'=> $exchange->updated_at
			);
		})
			->get();
	}


}
