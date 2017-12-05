<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Race;

class PicksReminded extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The user instance.
     *
     * @var	App\User
     */
    public $user;

    /**
     * The race instance.
     *
     * @var	App\Race
     */
    public $race;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( User $user, Race $race )
    {
    	$this->user	= $user;
    	$this->race	= $race;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( env('MAIL_FROM', 'pickems') )->view('mail.picksreminded.html')->text('mail.picksreminded.plain');
    }
}