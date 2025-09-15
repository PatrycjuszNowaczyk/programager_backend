<?php

namespace App\Manager\User\Application\Command;

final readonly class RegisterUserCommand {

    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
