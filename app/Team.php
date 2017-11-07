<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Team extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'name', 'country_id', 'active' ];

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
	 * Get country of this team.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function country()
	{
		return $this->belongsTo( Country::class )->withDefault();
	}
	
	/**
	 * Get entries of this team.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entries()
	{
		return $this->hasMany( Entry::class );
	}
}
