<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
	/**
	 * Get circuits in this country.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function circuits()
	{
		return $this->hasMany( Circuits::class, 'country_id' );
	}
}
