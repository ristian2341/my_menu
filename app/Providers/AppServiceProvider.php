<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Infrastructure\Auth\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider — Dependency Injection bindings.
 *
 * Binds domain interfaces to their infrastructure implementations.
 * This is the only place where concrete classes are coupled to abstractions.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Bind interfaces → concrete implementations (Dependency Inversion Principle).
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: UserRepositoryInterface::class,
            concrete: EloquentUserRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
