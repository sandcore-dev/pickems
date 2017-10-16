<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
	/**
	 * Get entries of this driver.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entry::class );
	}
}
