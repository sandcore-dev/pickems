<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'code', 'name' ];

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
	 * Get circuits in this country.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function circuits()
	{
		return $this->hasMany( Circuit::class );
	}
	
	/**
	 * Get drivers of this country.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function drivers()
	{
		return $this->hasMany( Driver::class );
	}
	
	/**
	 * Get teams of this country.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function teams()
	{
		return $this->hasMany( Team::class );
	}
}
