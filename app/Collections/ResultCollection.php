<?php

namespace App\Collections;

use App\Models\Result;

class ResultCollection extends PickCollection
{
    /**
     * Get a new instance of the object.
     *
     * @return \App\Models\Result
     */
    protected function getNewObject()
    {
        return new Result();
    }
}
