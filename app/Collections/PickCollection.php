<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Race;

class PickCollection extends Collection
{
	public function getByRace( Race $race )
	{
		return $this->where( 'race_id', $race->id )->all();
	}
}
