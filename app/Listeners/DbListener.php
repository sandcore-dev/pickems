<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DbListener
{
    /**
     * Query counter.
     *
     * @var	integer
     */
    public static $count = 0;
	
    /**
     * Query storage.
     *
     * @var	array
     */
    public static $queries = [];
	
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
    	self::$count++;
    	
    	self::$queries[] = $event->sql;
    }
    
    /**
     * Get queries as a collection.
     *
     * @return	\Illuminate\Support\Collection
     */
    public static function queries()
    {
    	return collect( self::$queries );
    }
}
