<?php

declare( strict_types = 1 );

namespace App\Manager\User\Domain\ValueObject;

use InvalidArgumentException;

final class VOEmail {
    private string $value;

    /**
     * @param string $value The email address.
     *
     * @throws InvalidArgumentException if the email is invalid.
     */
    public function __construct(
        string $value
    ) {
        $normalized = trim( mb_strtolower( $value ) );

        /**
         * 254 is the maximum length of an email address, according to RFC 5322.
         */
        if ( 254 < strlen( $normalized ) ) {
            throw new InvalidArgumentException( 'Email address is too long.' );
        }

        if ( 6 > strlen( $normalized ) ) {
            throw new InvalidArgumentException( 'Email address is too short.' );
        }

        if ( !filter_var( $normalized, FILTER_VALIDATE_EMAIL ) ) {
            throw new InvalidArgumentException( 'Invalid email address.' );
        }

        $this->value = $normalized;
    }

    /**
     * Returns the email value.
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
