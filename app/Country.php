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
		return $this->hasMany( Circuit::class, 'country_id' );
	}
}
