<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Race;

class PicksReminded extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * The race instance.
     *
     * @var Race
     */
    public $race;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Race $race
     */
    public function __construct(User $user, Race $race)
    {
        $this->user = $user;
        $this->race = $race;

        $this->subject(__(':appname reminder: :race', [
            'appname' => config('app.name'),
            'race' => $this->race->circuit->country->localName,
        ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.picksreminded.html')
            ->text('mail.picksreminded.text');
    }
}
