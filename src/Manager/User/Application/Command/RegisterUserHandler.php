<?php

declare(strict_types = 1);

namespace App\Manager\User\Application\Command;

use App\Manager\User\Domain\Enums\Role;
use App\Manager\User\Domain\User;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOPasswordHash;
use App\Manager\User\Domain\ValueObject\VOUserId;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler( bus: 'command.bus' )]
final class RegisterUserHandler {

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = User::register(
            new VOUserId(),
            new VOEmail( $command->email ),
            new VOPasswordHash( $command->password ),
            Role::USER,
            new DateTimeImmutable(),
        );

        $this->em->persist($user);
        $this->em->flush();
    }
}
