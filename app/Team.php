<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
	 * Get country of this team.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function country()
	{
		return $this->belongsTo( Country::class );
	}
	
	/**
	 * Get entries of this team.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entry::class );
	}
}
