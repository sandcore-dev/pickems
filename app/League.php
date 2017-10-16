<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
	/**
	* Get users of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function users()
	{
		return $this->belongsToMany( User::class );
	}
	
	/**
	* Get seasons of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function seasons()
	{
		return $this->belongsToMany( Season::class );
	}
}
