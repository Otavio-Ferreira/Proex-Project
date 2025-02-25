<?php

namespace App\Listeners\Autenticator;

use App\Events\Autenticator\UserCreated;
use App\Mail\Autenticator\EmailToSetPassword as AutenticatorEmailToSetPassword;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailToSetPassword implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = User::where('email', $event->email)->first();

        $email = new AutenticatorEmailToSetPassword(
            $event->name,
            $event->email,
            $event->time,
            $event->token,
            $event->title
        );
        Mail::to($user)->send($email);
    }
}
