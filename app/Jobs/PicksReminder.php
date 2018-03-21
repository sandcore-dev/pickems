<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

use App\Race;
use App\User;
use App\Pick;

use App\Mail\PicksReminded;

class PicksReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	$races = Race::with('season.series.leagues.users')->whereRaw( '(weekend_start - INTERVAL 1 DAY) BETWEEN UTC_TIMESTAMP() AND UTC_TIMESTAMP() + INTERVAL 59 MINUTE' )->get();

    	foreach( $races as $race )
    	{
    		$users = $race->season->series->leagues->pluck('users')->flatten(1)->unique()->where( 'active', 1 )->where( 'reminder', 1 );

    		foreach( $users as $user )
    		{
    			if( Pick::byRace($race)->byUser($user)->count() )
    				continue;

    			Mail::to( $user->email )->send( new PicksReminded( $user, $race ) );
    		}
    	}
    }
}
