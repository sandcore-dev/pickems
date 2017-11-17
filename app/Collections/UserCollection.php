<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Pick;
use App\Race;

class UserCollection extends Collection
{
	/**
	 * Get users in this collection with picks for a given race.
	 *
	 * @param	\App\Race	$race
	 *
	 * @return	\App\Collections\UserCollection
	 */
	public function getUsersWithPicksByRace(Race $race)
	{
		$picks = Pick::whereIn( 'league_user_id', $this->pluck('pivot.id') )->where( 'race_id', $race->id )->groupBy('league_user_id')->get();
		
		$users = $picks->map(function ($item, $key) {
			return $item->user;
		});
		
		$users = new self($users);
		
		// the global scope is not handling this, so we're sorting manually
		return $users->sortBy('name');
	}
}
