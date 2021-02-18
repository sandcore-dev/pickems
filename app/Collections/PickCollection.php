<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Race;
use App\Models\Pick;

class PickCollection extends Collection
{
    /**
     * Get picks of the given race.
     *
     * @parm \App\Models\Race
     *
     * @return \App\Collections\PickCollection
     */
    public function getByRace(Race $race)
    {
        return $this->where('race_id', $race->id)->sortBy('rank');
    }

    /**
     * Pad with missing ranks.
     *
     * @return \App\Collections\PickCollection
     */
    public function padMissing(int $picksMax = null)
    {
        if (!$picksMax) {
            $picksMax = config('picks.max');
        }

        $picks = $this->keyBy('rank')->all();

        foreach (range(1, $picksMax) as $index) {
            if (!isset($picks[$index])) {
                $picks[$index] = $this->getNewObject();
                $picks[$index]->rank = $index;
            }
        }

        ksort($picks);

        return new self($picks);
    }

    /**
     * Get a new instance of the object.
     *
     * @return \App\Models\Pick
     */
    protected function getNewObject()
    {
        return new Pick();
    }
}
