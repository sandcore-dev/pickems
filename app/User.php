<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'active', 'reminder', 'locale',
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
    	return $this->belongsToMany( League::class )->withTimestamps();
    }
    
    /**
     * Get standings of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function standings()
    {
    	return $this->hasMany( Standing::class );
    }
    
    /**
     * Get picks of this user.
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function picks()
    {
    	return $this->hasMany( Pick::class );
    }
}
