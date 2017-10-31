<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Pivots\PickUser;
use App\Race;
use App\Entry;
use App\Pick;

class NotPickedYet implements Rule
{
    /**
     * Required PickUser object.
     *
     * @var	App\Pivots\PickUser
     */
    protected $pivot;
    
    /**
     * Required Race object.
     *
     * @var	App\Race
     */
    protected $race;
    
    /**
     * Entry helper object.
     *
     * @var	App\Entry
     */
    protected $entry;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct( PickUser $pivot, Race $race )
    {
    	$this->pivot	= $pivot;
    	$this->race	= $race;
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
    	$this->entry = Entry::findOrFail($value);
    	
    	return Pick::where( 'race_id', $this->race->id )->where( 'entry_id', $this->entry->id )->where( 'league_user_id', $this->pivot->id )->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->entry->driver->full_name . ' has already been picked.';
    }
}
