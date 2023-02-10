<?php

namespace App\Providers;

use App\Repositories\BadWord\BadWordInterface;
use App\Repositories\BadWord\BadWordRepository;
use app\Repositories\BaseRepository;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Employee\EmployeeInterface;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Role\RoleInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Translate\TranslateInterface;
use App\Repositories\Translate\TranslateRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Carbon\Laravel\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(BadWordInterface::class, BadWordRepository::class);
        $this->app->bind(TranslateInterface::class, TranslateRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
