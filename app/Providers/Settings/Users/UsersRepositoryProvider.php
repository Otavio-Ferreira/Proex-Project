<?php

namespace App\Providers\Settings\Users;

use App\Repositories\Settings\Users\EloquentUsersRepository;
use App\Repositories\Settings\Users\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UsersRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsersRepository::class, EloquentUsersRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
