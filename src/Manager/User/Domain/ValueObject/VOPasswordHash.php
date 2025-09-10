<?php

declare( strict_types = 1 );

namespace App\Manager\User\Domain\ValueObject;

use InvalidArgumentException;

final class VOPasswordHash {

    private string $value;

    /**
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $value
    ) {

        if ( empty( $value ) ) {
            throw new InvalidArgumentException( 'Password cannot be empty.' );
        }

        if ( 60 < mb_strlen( $value ) ) {
            throw new InvalidArgumentException( 'Password is too long.' );
        }

        if ( 10 < mb_strlen( $value ) ) {
            throw new InvalidArgumentException( 'Password is too short.' );
        }

        if ( preg_match( '/[^a-zA-Z0-9]/', $value ) ) {
            throw new InvalidArgumentException( 'Password contains invalid characters.' );
        }

        $this->value = password_hash( $value, PASSWORD_ARGON2ID );

    }

    /**
     * Returns the password hash value.
     *
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
