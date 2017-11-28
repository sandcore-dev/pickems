<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Circuit extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'name', 'length', 'city', 'area', 'country_id' ];

	/**
	 * Get country of this circuit.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function country()
	{
		return $this->belongsTo( Country::class );
	}

	/**
	 * Get races of this circuit.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function races()
	{
		return $this->hasMany( Race::class );
	}

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
	 * Get the place of this circuit.
	 *
	 * @return 	string
	 */
	public function getLocationAttribute()
	{
		return $this->city . ', ' . ( $this->area ? $this->area . ', ' : '' ) . $this->country->name;
	}

	/**
	 * Get the short noation of the place of this circuit.
	 *
	 * @return 	string
	 */
	public function getLocationShortAttribute()
	{
		return $this->city . ', ' . $this->country->name;
	}
}
