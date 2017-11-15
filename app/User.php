<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Builder;

use App\Pivots\PickUser;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'active', 'reminder',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
    	parent::boot();

	static::addGlobalScope('sortByUsername', function (Builder $builder) {
	    $builder->orderBy('username', 'asc');
	});
    }

    /**
     * Get leagues of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function leagues()
    {
    	return $this->belongsToMany( League::class )->using(PickUser::class)->withPivot('id');
    }
    
    /**
     * Get picks of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function picks()
    {
    	return $this->belongsToMany( Pick::class, 'league_user', 'user_id', 'id', null, 'league_user_id' );
    }
}
