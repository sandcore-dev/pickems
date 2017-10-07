<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuits extends Model
{
	/**
	 * Get country of this circuit.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection;
	 */
	public function country()
	{
		return $this->hasOne( Countries::class, 'country_id' );
	}
}
