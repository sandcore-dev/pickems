<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
	/**
	 * Get series of this season.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function series()
	{
		return $this->belongsTo( Series::class, 'series_id' );
	}
}
