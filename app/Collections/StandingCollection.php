<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Standing;

class StandingCollection extends Collection
{
	/**
	 * Return all (unique) users of this collection.
	 *
	 * @return	Illuminate\Database\Eloquent\Collection
	 */
	public function users()
	{
		return $this->map(function ($item, $key) {
			return $item->user;
		})->unique()->sortBy('name');
	}
	
	/**
	 * Output a collection compatible with Highcharts series data.
	 *
	 * @return	Illuminate\Support\Collection
	 */
	public function getChartData()
	{
		$out = [];
		
		$out[] = [
			'type'	=> 'area',
			'name'	=> __('Ranking'),
			'data'	=> $this->getData('rank'),
		];

		$out[] = [
			'type'	=> 'column',
			'name'	=> __('Top :number', [ 'number' => config('picks.max') ]),
			'data'	=> $this->getData('picked'),
		];
		
		$out[] = [
			'type'	=> 'column',
			'name'	=> __('Total'),
			'data'	=> $this->getData('total'),
		];
		
		$out[] = [
			'type'	=> 'column',
			'name'	=> __('Finish'),
			'data'	=> $this->getData('positions_correct'),
		];
		
		$out[] = [
			'type'	=> 'line',
			'name'	=> __('Average total score'),
			'color'	=> '#ff0000',
			'data'	=> $this->getData(function ($data) {
				$average = Standing::where( 'race_id', $data->race_id )->whereIn( 'user_id', $data->league->users->pluck('id') )->avg('total');
				
				return round( $average, 1 );
			}),
		];
		
		return collect($out);
	}
	
	/**
	 * Get data from field or callable.
	 *
	 * @param	string|callable	$field
	 * @return	Illuminate\Support\Collection;
	 */
	protected function getData( $field )
	{
		$out = [];
		
		foreach( $this as $standing )
			$out[] = [ 'name' => $standing->race->circuit->localLocationShort, 'y' => is_callable($field) ? $field($standing) : $standing->{ $field } ];
		
		return collect($out);
	}
}
