<?php

namespace App\Manager\User\Domain\Repository;

use App\Manager\User\Domain\User;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOUserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findAll(): array;

    public function findById(VOUserId $id): ?User;

    public function findByEmail(VOEmail $email): ?User;

    public function delete(VOUserId $id): void;

    public function nextIdentity(): VOUserId;
}
