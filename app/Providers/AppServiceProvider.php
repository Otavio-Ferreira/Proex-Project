<?php

namespace App\Providers;

use App\Repositories\Course\CourseRepository;
use App\Repositories\Course\EloquentCourseRepository;
use App\Repositories\Forms\InternalPartner\InternalPartnerRepository;
use App\Repositories\Forms\Activity\ActivityRepository;
use App\Repositories\Forms\Activity\EloquentActivityRepository;
use App\Repositories\Forms\ExtensionAction\EloquentExtensionActionRepository;
use App\Repositories\Forms\ExtensionAction\ExtensionActionRepository;
use App\Repositories\Forms\ExternalPartner\EloquentExternalPartnerRepository;
use App\Repositories\Forms\ExternalPartner\ExternalPartnerRepository;
use App\Repositories\Forms\Form\EloquentFormRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Image\EloquentImageRepository;
use App\Repositories\Forms\Image\ImageRepository;
use App\Repositories\Forms\InternalPartner\EloquentInternalPartnerRepository;
use App\Repositories\Forms\Response\EloquentResponseRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use App\Repositories\Forms\SocialMedia\EloquentSocialMediaRepository;
use App\Repositories\Forms\SocialMedia\SocialMediaRepository;
use App\Repositories\Persons\EloquentPersonsRepository;
use App\Repositories\Persons\PersonsRepository;
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
        $this->app->bind(InternalPartnerRepository::class, EloquentInternalPartnerRepository::class);
        $this->app->bind(ExternalPartnerRepository::class, EloquentExternalPartnerRepository::class);
        $this->app->bind(ExtensionActionRepository::class, EloquentExtensionActionRepository::class);
        $this->app->bind(SocialMediaRepository::class, EloquentSocialMediaRepository::class);
        $this->app->bind(ImageRepository::class, EloquentImageRepository::class);
        $this->app->bind(PersonsRepository::class, EloquentPersonsRepository::class);
        $this->app->bind(CourseRepository::class, EloquentCourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
