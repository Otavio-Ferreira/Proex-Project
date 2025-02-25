<?php

namespace App\Listeners\Autenticator;

use App\Events\Autenticator\TokenCreated;
use App\Mail\Autenticator\EmailToResetPassword as AutenticatorEmailToResetPassword;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailToResetPassword implements ShouldQueue
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
    public function handle(TokenCreated $event): void
    {
        $user = User::where('email', $event->email)->first();

        $email = new AutenticatorEmailToResetPassword(
            $event->name,
            $event->email,
            $event->time,
            $event->token,
            $event->title
        );
        Mail::to($user)->send($email);

    }
}
