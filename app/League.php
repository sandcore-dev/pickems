<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class League extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'series_id', 'name', 'access_token' ];

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
		return $this->belongsToMany( User::class )->withTimestamps();
	}
	
	/**
	* Get series of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function series()
	{
		return $this->belongsTo( Series::class );
	}
	
	/**
	* Get standings of this league.
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function standings()
	{
		return $this->hasMany( Standing::class );
	}
	
	/**
	 * Scope query by token.
	 * 
	 * @param	string	$token
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByToken( $query, $token )
	{
		return $query->whereNotNull( 'access_token' )->where( 'access_token', $token );
	}
	
	/**
	 * Get next race according to weekend_start.
	 *
	 * @return	\App\Race|null
	 */
	public function getNextDeadlineAttribute()
	{
		$nextDeadline = $this->series->first()->seasons->first()->races()->nextDeadline();
		
		return $nextDeadline->count() ? $nextDeadline->first() : null;
	}
}
