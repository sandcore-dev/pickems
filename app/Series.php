<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Season;

class Series extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'name' ];
	 
	/**
 	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('orderByName', function (Builder $builder) {
			$builder->orderBy('name', 'asc');
		});
	}
    
    	/**
	 * Get seasons of this series
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function seasons()
	{
		return $this->hasMany( Season::class );
	}
	
	/**
	 * Get latest (most recent by year) season.
	 *
	 * @return	\App\Season
	 */
	public function getLatestSeasonAttribute()
	{
		if( $this->seasons->isEmpty() )
			return new Season;
			
		return $this->seasons->sortByDesc('name')->first();
	}
}
