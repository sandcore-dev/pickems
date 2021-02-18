<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\Race;
use App\Models\Pick;

class MaxPicksExceeded implements Rule
{
    /**
     * Required User object.
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
     * Maximum number picks allowed.
     *
     * @var integer
     */
    protected $maxPicks;

    /**
     * Create a new rule instance.
     *
     * @param User $user
     * @param Race $race
     * @param int $maxPicks
     */
    public function __construct(User $user, Race $race, int $maxPicks)
    {
        $this->user = $user;
        $this->race = $race;
        $this->maxPicks = $maxPicks;
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
        return Pick::where('race_id', $this->race->id)->where('user_id', $this->user->id)->count() < $this->maxPicks;
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
