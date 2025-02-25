<?php

namespace App\Providers\Settings\Roles;

use App\Repositories\Settings\Roles\EloquentRolesRepository;
use App\Repositories\Settings\Roles\RolesRepository;
use Illuminate\Support\ServiceProvider;

class RolesRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RolesRepository::class, EloquentRolesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
