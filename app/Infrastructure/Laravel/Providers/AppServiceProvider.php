<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Auth\AuthUser;
use App\Application\Auth\Contracts\AuthUserInterface;
use App\Domain\Employees\Aggregate\Employee;
use App\Domain\Employees\Contracts\EmployeeInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthUserInterface::class, AuthUser::class);
        $this->app->bind(EmployeeInterface::class, Employee::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
