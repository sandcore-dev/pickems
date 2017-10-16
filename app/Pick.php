<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
	/**
	 * Get the race of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->hasOne( Race::class );
	}

	/**
	 * Get the entry of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->hasOne( Entry::class );
	}

	/**
	 * Get the user of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->hasOne( User::class );
	}
}
