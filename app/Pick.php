<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
	/**
	 * Get the race of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}

	/**
	 * Get the entry of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->belongsTo( Entry::class );
	}

	/**
	 * Get the user of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->belongsTo( User::class, 'league_user_id' );
	}

	/**
	 * Get the league of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function league()
	{
		return $this->belongsTo( League::class, 'league_user_id' );
	}
}
