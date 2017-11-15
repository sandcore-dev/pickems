<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Pivots\PickUser;

use App\Standing;

class League extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'name' ];

	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('sortByName', function (Builder $builder) {
		    $builder->orderBy('name', 'asc');
		});
	}

	/**
	* Get users of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function users()
	{
		return $this->belongsToMany( User::class )->using(PickUser::class)->withPivot('id');
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
		return $this->belongsToMany( Pick::class, 'league_user', 'league_id', 'id', null, 'league_user_id' );
	}
	
	/**
	* Get standings of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function standings()
	{
		return $this->belongsToMany( Standing::class, 'league_user', 'league_id', 'id', null, 'league_user_id' );
	}
	
	/**
	 * Get next race according to weekend_start.
	 *
	 * @return	\App\Race|null
	 */
	public function getNextDeadlineAttribute()
	{
		$nextDeadline = $this->seasons->first()->races()->nextDeadline();
		
		return $nextDeadline->count() ? $nextDeadline->first() : null;
	}
	
	/**
	 * Get best result of the latest season.
	 *
	 * @return	\App\Standing
	 */
	public function getCurrentSeasonBestResultAttribute()
	{
		$standings = Standing::where( 'league_user_id', $this->pivot->id )->whereIn( 'race_id', $this->seasons->first()->races->pluck('id') )->withoutGlobalScope('sortByRaceRank')->orderBy( 'positions_correct', 'desc' )->orderBy( 'picked', 'desc' );
		
		return $standings->count() ? $standings->first() : null;
	}
}
