<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
	/**
	 * Get seasons of this series
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function seasons()
	{
		return $this->hasMany( Season::class );
	}
}
