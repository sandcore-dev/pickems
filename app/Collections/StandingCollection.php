<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Standing;

class StandingCollection extends Collection
{
	/**
	 * Output a collection compatible with Highcharts series data.
	 *
	 * @return	Illuminate\Database\Eloquent\Collection;
	 */
	public function getChartData()
	{
		$out = [];
		
		$out[] = [
			'type'	=> 'area',
			'name'	=> 'Ranking',
			'data'	=> $this->getData('rank'),
		];

		$out[] = [
			'type'	=> 'column',
			'name'	=> 'Total',
			'data'	=> $this->getData(function ($data) {
					return $data->picked + $data->positions_correct;
			}),
		];
		
		$out[] = [
			'type'	=> 'column',
			'name'	=> 'Top ' . config('picks.max'),
			'data'	=> $this->getData('picked'),
		];
		
		$out[] = [
			'type'	=> 'column',
			'name'	=> 'Finish',
			'data'	=> $this->getData('positions_correct'),
		];
		
		$out[] = [
			'type'	=> 'line',
			'name'	=> 'Average total score',
			'color'	=> '#ff0000',
			'data'	=> $this->getData(function ($data) {
				$average = Standing::where( 'race_id', $data->race_id )->whereIn( 'user_id', $data->league->users->pluck('id') )->get()->avg('total');
				
				return round( $average, 1 );
			}),
		];
		
		return collect($out);
	}
	
	/**
	 * Get data from field or callable.
	 *
	 * @param	string|callable	$field
	 * @return	Illuminate\Database\Eloquent\Collection;
	 */
	protected function getData( $field )
	{
		$out = [];
		
		foreach( $this as $standing )
			$out[] = [ 'name' => $standing->race->circuit->country->name, 'y' => is_callable($field) ? $field($standing) : $standing->{ $field } ];
		
		return collect($out);
	}
}
