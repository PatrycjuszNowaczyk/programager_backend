<?php

declare( strict_types = 1 );

namespace App\Manager\User\Domain;

use App\Manager\User\Domain\Enums\UserRole;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOPasswordHash;
use App\Manager\User\Domain\ValueObject\VOUserId;
use DateTimeImmutable;

readonly class User {
    private function __construct(
        private VOUserId $id,
        private VOEmail $email,
        private VOPasswordHash $password_hash,
        private UserRole $role,
        private DateTimeImmutable $created_at,
    ) {
    }

    public function getId(): VOUserId {
        return $this->id;
    }

    public function getEmail(): VOEmail {
        return $this->email;
    }

    public function getPasswordHash(): VOPasswordHash {
        return $this->password_hash;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function getCreatedAt(): DateTimeImmutable {
        return $this->created_at;
    }

    public static function register(
        VOUserId $id,
        VOEmail $email,
        VOPasswordHash $password_hash,
        UserRole $role,
        DateTimeImmutable $created_at,
    ): self {
        return new self(
            $id,
            $email,
            $password_hash,
            $role,
            $created_at,
        );
    }
}
