<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	/**
	 * Get series of this season.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function series()
	{
		return $this->belongsTo( Series::class );
	}

	/**
	* Get leagues of this season.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function leagues()
	{
		return $this->belongsToMany( League::class );
	}
}
