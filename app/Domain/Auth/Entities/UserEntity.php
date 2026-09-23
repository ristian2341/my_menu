<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entities;

/**
 * UserEntity — Pure domain entity.
 * No framework dependencies, no Eloquent.
 */
final class UserEntity
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $hashedPassword,
        public readonly \DateTimeImmutable $createdAt,
    ) {}

    /**
     * Check if the provided plain-text password matches the stored hash.
     */
    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    /**
     * Mask the email for safe display (e.g. "j***@example.com").
     */
    public function maskedEmail(): string
    {
        [$local, $domain] = explode('@', $this->email, 2);

        return substr($local, 0, 1) . str_repeat('*', max(strlen($local) - 1, 3)) . '@' . $domain;
    }
}
