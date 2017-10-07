<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picks extends Model
{
	/**
	 * Get the race of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->hasOne( Races::class, 'race_id' );
	}

	/**
	 * Get the entry of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->hasOne( Entries::class, 'entry_id' );
	}

	/**
	 * Get the user of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->hasOne( User::class, 'user_id' );
	}
}
