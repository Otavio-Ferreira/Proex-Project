<?php

namespace App\Providers\Authentication;

use App\Repositories\Authentication\EloquentLoginRepository;
use App\Repositories\Authentication\LoginRepository;
use Illuminate\Support\ServiceProvider;

class LoginRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        LoginRepository::class => EloquentLoginRepository::class
    ];

    // public function register(): void
    // {
    //     // Registra o binding da interface para a implementaçãos
    //     $this->app->bind(LoginRepository::class, EloquentLoginRepository::class);
    // }

    // public function boot(): void
    // {
    //     // Outros serviços podem ser registrados aqui, se necessário
    // }
}
