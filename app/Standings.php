<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standings extends Model
{
	/**
	 * Get the race of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->hasOne( Races::class, 'race_id' );
	}
	
	/**
	 * Get the user of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->hasOne( User::class, 'user_id' );
	}
	
	/**
	 * Get the previous race entry of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function previous()
	{
		return $this->hasOne( Standings::class, 'previous_id' );
	}
}
