<?php

declare(strict_types=1);

namespace App\Application\Auth\UseCases;

use App\Application\Auth\DTOs\RegisterDTO;
use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Entities\UserEntity;
use Illuminate\Support\Facades\Auth;

/**
 * RegisterUseCase — Single responsibility: register a new user.
 *
 * Orchestrates domain logic without knowing about HTTP or UI.
 */
final class RegisterUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * Execute the registration use case.
     *
     * @throws \DomainException When email is already taken.
     */
    public function execute(RegisterDTO $dto): UserEntity
    {
        $existing = $this->userRepository->findByEmail($dto->email);

        if ($existing !== null) {
            throw new \DomainException('Email sudah terdaftar. Silakan gunakan email lain.');
        }

        $user = $this->userRepository->create(
            name: $dto->name,
            email: $dto->email,
            hashedPassword: password_hash($dto->password, PASSWORD_BCRYPT),
        );

        Auth::loginUsingId($user->id);

        return $user;
    }
}
