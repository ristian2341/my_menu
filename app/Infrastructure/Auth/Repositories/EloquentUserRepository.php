<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Repositories;

use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Entities\UserEntity;
use App\Models\User;

/**
 * EloquentUserRepository — Infrastructure layer.
 *
 * Implements the domain contract using Eloquent ORM.
 * Isolates Eloquent from the domain and application layers.
 */
final class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Find a user by their email address.
     */
    public function findByEmail(string $email): ?UserEntity
    {
        $model = User::query()->where('email', $email)->first();

        if ($model === null) {
            return null;
        }

        return $this->toEntity($model);
    }

    /**
     * Create a new user and return the domain entity.
     */
    public function create(string $name, string $email, string $hashedPassword): UserEntity
    {
        $model = User::query()->create([
            'name'     => $name,
            'email'    => $email,
            'password' => $hashedPassword,
        ]);

        return $this->toEntity($model);
    }

    /**
     * Map an Eloquent model to a pure domain entity.
     */
    private function toEntity(User $model): UserEntity
    {
        return new UserEntity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            hashedPassword: $model->password,
            createdAt: \DateTimeImmutable::createFromMutable($model->created_at->toDateTime()),
        );
    }
}
