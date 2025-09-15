<?php

namespace App\Manager\User\Application\Command;

use App\Manager\User\Domain\Enums\Role;
use App\Manager\User\Domain\User;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOPasswordHash;
use App\Manager\User\Domain\ValueObject\VOUserId;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler( bus: 'command.bus' )]
final class RegisterUserHandler {

    public function __construct() {
    }

    public function __invoke( RegisterUserCommand $command ): string {
        $user = User::register(
            new VOUserId(),
            new VOEmail( $command->email ),
            new VOPasswordHash( $command->password ),
            Role::USER,
            new DateTimeImmutable(),
        );

        return "User registered with email: {$user->getEmail()} and password: {$user->getPasswordHash()}";
    }
}
