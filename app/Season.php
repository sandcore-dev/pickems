<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Season extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'series_id', 'start_year', 'end_year' ];

	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('sortByStartAndEnd', function (Builder $builder) {
		    $builder->orderBy('start_year', 'desc')->orderBy('end_year', 'desc');
		});
	}
    
    	/**
	 * Get series of this season.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function series()
	{
		return $this->belongsTo( Series::class );
	}

	/**
	* Get races of this season.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function races()
	{
		return $this->hasMany( Race::class );
	}

	/**
	* Get entries of this season.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function entries()
	{
		return $this->hasMany( Entry::class );
	}

	/**
	* Get leagues of this season.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function leagues()
	{
		return $this->belongsToMany( League::class );
	}
	
	/**
	 * Get the season's name.
	 *
	 * @return 	string
	 */
	public function getNameAttribute()
	{
		$out = $this->start_year;
		
		if( $this->start_year != $this->end_year )
			$out .= '-' . $this->end_year;
		
		return $out;
	}
}
