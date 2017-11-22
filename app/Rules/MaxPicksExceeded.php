<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\User;
use App\Race;
use App\Pick;

class MaxPicksExceeded implements Rule
{
    /**
     * Required User object.
     *
     * @var	App\User
     */
    protected $user;
    
    /**
     * Required Race object.
     *
     * @var	App\Race
     */
    protected $race;
    
    /**
     * Maximum number picks allowed.
     *
     * @var	integer
     */
    protected $maxPicks;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct( User $user, Race $race, int $maxPicks )
    {
    	$this->user	= $user;
    	$this->race	= $race;
    	$this->maxPicks	= $maxPicks;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Pick::where( 'race_id', $this->race->id )->where( 'user_id', $this->user->id )->count() < $this->maxPicks;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "You cannot pick more than {$this->maxPicks} drivers.";
    }
}
