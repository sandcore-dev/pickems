<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Driver extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'first_name', 'last_name', 'country_id', 'active' ];

	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('sortByName', function (Builder $builder) {
		    $builder->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
		});
	}

	/**
	 * Get country of this driver.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function country()
	{
		return $this->belongsTo( Country::class )->withDefault();
	}
	
	/**
	 * Get entries of this driver.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entry::class );
	}
	
	/**
	 * Get full name of this driver.
	 *
	 * @return	string
	 */
	public function getFirstLetterAttribute()
	{
		return substr( $this->first_name, 1, 1 ) . '.';
	}
	
	/**
	 * Get full name of this driver.
	 *
	 * @return	string
	 */
	public function getFullNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
	
	/**
	 * Get full name of this driver, with last name first and then a comma.
	 *
	 * @return	string
	 */
	public function getLastFirstAttribute()
	{
		return $this->last_name . ', ' . $this->first_name;
	}
}
