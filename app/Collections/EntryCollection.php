<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class EntryCollection extends Collection
{
	public function getByTeam()
	{
		return $this->where('active', 1)->sortBy('driver.name')->sortBy('team.name')->mapToGroups( function ($item) {
			return [ $item->team->name => $item ];
		})->all();
	}
}
