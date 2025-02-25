<?php

namespace App\Providers;

use App\Events\Autenticator\TokenCreated;
use App\Events\Autenticator\UserCreated;
use App\Listeners\Autenticator\EmailToResetPassword;
use App\Listeners\Autenticator\EmailToSetPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TokenCreated::class => [
            EmailToResetPassword::class,
        ],
        UserCreated::class => [
            EmailToSetPassword::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
