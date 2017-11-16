<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Standing;

class PickUser extends Pivot
{
	public function standings()
	{
		return $this->hasMany( Standing::class, 'league_user_id' );
	}
}
