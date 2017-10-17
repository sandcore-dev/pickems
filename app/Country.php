<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
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
