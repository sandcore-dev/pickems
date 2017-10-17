<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
	/**
	 * Get the race of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}
	
	/**
	 * Get the entry of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->belongsTo( Entry::class );
	}
}
