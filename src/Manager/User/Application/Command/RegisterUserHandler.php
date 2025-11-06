<?php

declare(strict_types = 1);

namespace App\Manager\User\Application\Command;

use App\Manager\User\Domain\Enums\UserRole;
use App\Manager\User\Domain\Repository\UserRepositoryInterface;
use App\Manager\User\Domain\User;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOPasswordHash;
use App\Manager\User\Domain\ValueObject\VOUserId;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class RegisterUserHandler
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $userData = [
            'id'        => new VOUserId(),
            'email'     => new VOEmail($command->email),
            'password'  => new VOPasswordHash($command->password),
            'role'      => UserRole::USER,
            'createdAt' => new DateTimeImmutable(),
        ];

        $user = User::register(...array_values($userData));

        $this->userRepository->save($user);
    }
}
