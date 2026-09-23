<?php

declare(strict_types=1);

namespace App\Application\Auth\DTOs;

/**
 * Data Transfer Object for registration input.
 * Immutable — carries only validated, clean data.
 */
final readonly class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    /**
     * Create from raw (pre-validated) array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: trim($data['name']),
            email: strtolower(trim($data['email'])),
            password: $data['password'],
        );
    }
}
