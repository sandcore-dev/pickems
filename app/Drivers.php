<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
	/**
	 * Get entries of this driver.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entries::class, 'driver_id' );
	}
}
