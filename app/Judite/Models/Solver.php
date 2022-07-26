<?php

namespace App\Judite\Models;


use Illuminate\Support\Collection;
use GuzzleHttp\Client;
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
        $client = new Client();
		$url = env('SOLVER_URL','10.0.2.2').":".env('SOLVER_PORT','4567');
        $response = $client->request('POST',$url,['body'=>json_encode(['exchange_requests' => Solver::changeExchangeToSolverType($course->automaticExchanges())])]);
		$exchanges_ids = json_decode($response->getBody(), true)["solved_exchanges"];
        foreach ($exchanges_ids as $exchange_id){
            Exchange::Find($exchange_id)->perform();
        }
        return $exchanges_ids;
	}

	public static function SolveConditionalExchanges()
	{
		$client = new Client();
		$url = env('SOLVER_URL','10.0.2.2').":".env('SOLVER_PORT','4567');
        $response = $client->request('POST',$url,['body'=>json_encode(['exchange_requests' => Solver::changeConditionalExchangeToSolverType(ConditionalExchange::all())])]);
		$conditional_exchanges_ids = json_decode($response->getBody(), true)["solved_exchanges"];
		foreach ($conditional_exchanges_ids as $conditional_exchanges_id){
            $conditionalExchange = ConditionalExchange::Find($conditional_exchanges_id);
			$exchanges = $conditionalExchange->hasMany(Exchange::Class);
			foreach ($exchanges as $exchange){
				$exchange->perform();
			}
        }
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
        $values = collect();
        $query->each(function ($exchange) use ($values) {
            $values->push(array(
                'id' => $exchange->id,
                'from_shift_id' => $exchange->fromShift()->tag,
                'to_shift_id' => $exchange->toShift()->tag,
                'created_at' => $exchange->updated_at->timestamp
            ));
        });
        return $values;
	}

	private static function changeConditionalExchangeToSolverType($query){
		$values = collect();
		$query->each(function ($conditionalExchange) use ($values) {
			$exchanges = $conditionalExchange->hasMany(Exchange::Class);
            $values->push(array(
                'id' => $conditionalExchange->id,
				'timestamp' => $conditionalExchange->timestamp,
				'student' => $exchanges->first()->fromStudent(),
				'exchanges' => array_map(function($exchange){
					return[
						'id' => $exchange->id,
						'course' => $exchange->course()->name,
						'from_shift' => $exchange->fromShift->tag,
						'to_shift' => $exchange->toShift->tag,
					];
				}
				,$exchanges)
            ));
        });
        return $values;
	}


}
