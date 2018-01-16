<?php

namespace App\Listeners;

use App\Mail\UserRegistered;
use Illuminate\Auth\Events\Registered;

class SendRegistrationConfirmationEmail
{
    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        \Mail::to($event->user)->send(new UserRegistered());
    }
}
