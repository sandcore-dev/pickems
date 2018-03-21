<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use App\Jobs\PicksReminder;
use App\Mail\PicksReminded;
use App\Race;

class PicksReminderTest extends TestCase
{
    /**
     * Test sending the pickems reminder.
     *
     * @return void
     */
    public function testSendReminder()
    {
        Mail::fake();

        $race = Race::nextOrLast();

        $original = $race->weekend_start;

        $race->weekend_start = new Carbon('+1 day 5 minutes');

        $race->save();

        PicksReminder::dispatch();

        Mail::assertSent(PicksReminded::class);

        $race->weekend_start = $original;

        $race->save();
    }
}
