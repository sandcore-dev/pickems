<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Monarobase\CountryList\CountryListFacade as Countries;
use Monarobase\CountryList\CountryNotFoundException;

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
	
	/**
	 * Get the flag class of this country.
	 *
	 * @return	string
	 */
	public function getFlagClassAttribute()
	{
		return 'flag-icon flag-icon-' . strtolower( $this->code );
	}

	/**
	 * Get the name of this country in the current locale.
	 *
	 * @return	string
	 */
	public function getLocalNameAttribute()
	{
		try {
			return Countries::getOne( $this->code, app()->getLocale() );
		}
		catch( CountryNotFoundException $e ) {
			error_log( 'CountryNotFoundException: ' . $e->getMessage() );
		}
		
		return $this->name;
	}
}
