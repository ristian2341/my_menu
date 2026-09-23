<?php

declare(strict_types=1);

namespace App\Application\Auth\UseCases;

use App\Application\Auth\DTOs\LoginDTO;
use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Entities\UserEntity;
use Illuminate\Support\Facades\Auth;

/**
 * LoginUseCase — Single responsibility: authenticate a user.
 *
 * Orchestrates domain logic without knowing about HTTP or UI.
 */
final class LoginUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * Execute the login use case.
     *
     * @throws \DomainException When credentials are invalid.
     */
    public function execute(LoginDTO $dto): UserEntity
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if ($user === null || ! $user->verifyPassword($dto->password)) {
            throw new \DomainException('Kredensial yang diberikan tidak cocok dengan data kami.');
        }

        Auth::loginUsingId($user->id, $dto->remember);

        return $user;
    }
}
