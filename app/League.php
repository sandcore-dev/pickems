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
	
	/**
	* Get picks of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function picks()
	{
		return $this->belongsToMany( Pick::class, 'league_user', 'id', 'league_id' );
	}
	
	/**
	* Get standings of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function standings()
	{
		return $this->belongsToMany( Standing::class, 'league_user', 'id', 'league_id' );
	}
}
