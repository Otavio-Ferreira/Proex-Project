<?php

namespace App\Providers;

use App\Repositories\Forms\Activity\ActivityRepository;
use App\Repositories\Forms\Activity\EloquentActivityRepository;
use App\Repositories\Forms\Form\EloquentFormRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\EloquentResponseRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FormRepository::class, EloquentFormRepository::class);
        $this->app->bind(ResponseRepository::class, EloquentResponseRepository::class);
        $this->app->bind(ActivityRepository::class, EloquentActivityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
