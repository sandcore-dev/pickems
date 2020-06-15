<?php

namespace App\Collections;

use App\Result;

class ResultCollection extends PickCollection
{
    /**
     * Get a new instance of the object.
     *
     * @return \App\Result
     */
    protected function getNewObject()
    {
        return new Result();
    }
}
