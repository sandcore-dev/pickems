<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'is_active',
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
     * Get leagues of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function leagues()
    {
    	return $this->belongsToMany( League::class );
    }
    
    /**
     * Get picks of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function picks()
    {
    	return $this->belongsToMany( Pick::class, 'league_user', 'user_id', 'id' );
    }
}
