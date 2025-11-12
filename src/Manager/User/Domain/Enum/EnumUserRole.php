<?php

namespace App\Manager\User\Domain\Enum;

enum EnumUserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function isAdmin(): bool {
        return $this === self::ADMIN;
    }
}
