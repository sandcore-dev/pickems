<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\Race;
use App\Models\Entry;
use App\Models\Pick;

class NotPickedYet implements Rule
{
    /**
     * Required PickUser object.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Required Race object.
     *
     * @var \App\Models\Race
     */
    protected $race;

    /**
     * Entry helper object.
     *
     * @var \App\Models\Entry
     */
    protected $entry;

    /**
     * Create a new rule instance.
     *
     * @param User $user
     * @param Race $race
     */
    public function __construct(User $user, Race $race)
    {
        $this->user = $user;
        $this->race = $race;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->entry = Entry::findOrFail($value);

        return Pick::where('race_id', $this->race->id)
                ->where('entry_id', $this->entry->id)
                ->where('user_id', $this->user->id)
                ->count() == 0;
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
