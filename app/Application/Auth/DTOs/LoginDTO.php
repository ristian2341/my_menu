<?php

declare(strict_types=1);

namespace App\Application\Auth\DTOs;

/**
 * Data Transfer Object for login input.
 * Immutable — validated data only enters the application layer as a DTO.
 */
final readonly class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember,
    ) {}

    /**
     * Create from raw (pre-validated) array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: strtolower(trim($data['email'])),
            password: $data['password'],
            remember: (bool) ($data['remember'] ?? false),
        );
    }
}
