<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
	/**
	 * Get entries of this team.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entries::class, 'team_id' );
	}
}
