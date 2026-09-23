<?php

declare(strict_types=1);

namespace App\Domain\Auth\Contracts;

use App\Domain\Auth\Entities\UserEntity;

/**
 * Contract for User Repository.
 * Domain layer — framework agnostic.
 */
interface UserRepositoryInterface
{
    /**
     * Find a user by their email address.
     */
    public function findByEmail(string $email): ?UserEntity;

    /**
     * Create a new user and return the entity.
     */
    public function create(string $name, string $email, string $hashedPassword): UserEntity;
}
