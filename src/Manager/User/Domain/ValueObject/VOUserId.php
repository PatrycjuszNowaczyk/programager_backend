<?php

declare( strict_types = 1 );

namespace App\Manager\User\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

final class VOUserId {
    private Uuid $value;

    /**
     * @param string|null $value
     */
    public function __construct(
        ?string $value = null
    ) {
        if ( $value ) {
            $this->value = Uuid::fromString( $value );

            return;
        }

        $this->value = Uuid::v4();
    }

    /**
     * Returns the user id - Uuid.
     *
     * @return Uuid The value.
     */
    public function getValue(): Uuid {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value->toString();
    }

    public static function generateNewId(): self
    {
        return new self();
    }
}
