<?php

namespace App\Manager\User\Infrastructure\Dto;

final readonly class UserDto {
    public function __construct(
        public string $id,
        public string $email,
        public string $password_hash,
        public string $role,
    ) {
    }
}
