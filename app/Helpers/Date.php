<?php

namespace App\Helpers;

use Carbon\Carbon;

class Date
{
    /**
     * Get date next year with the closest weekday.
     * 
     * @param	\Carbon\Carbon	$date
     * @return	\Carbon\Carbon
     */
    public static function getClosestWeekdayNextYear( Carbon $date )
    {
		$nextYear			= $date->copy()->addYear();
		
		$previousDayOfWeek	= $nextYear->copy()->previous( $date->dayOfWeek )->hour( $date->hour )->minute( $date->minute )->second( $date->second );
		$nextDayOfWeek		= $nextYear->copy()->next( $date->dayOfWeek )->hour( $date->hour )->minute( $date->minute )->second( $date->second );
		
		return $nextYear->diffInDays( $previousDayOfWeek ) < $nextYear->diffInDays( $nextDayOfWeek ) ? $previousDayOfWeek : $nextDayOfWeek;
    }
}
