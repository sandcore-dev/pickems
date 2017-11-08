<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Collections\ResultCollection;

class Result extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'race_id', 'entry_id', 'rank' ];

	/**
	* Creates a new Collection instance of this model.
	*
	* @param	array	$models
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function newCollection( array $models = [] )
	{
		return new ResultCollection( $models );
	}

	/**
	 * Get the race of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}
	
	/**
	 * Get the entry of this result.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->belongsTo( Entry::class );
	}
}
