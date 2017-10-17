<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
	/**
	 * Get country of this circuit.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection;
	 */
	public function country()
	{
		return $this->belongsTo( Country::class );
	}
}
