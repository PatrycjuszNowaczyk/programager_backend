<?php

declare( strict_types = 1 );

namespace App\Manager\User\Domain\ValueObject;

final class VOUserId {
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(
        string $value
    ) {
        $this->value = $value;
    }

    /**
     * Returns the user id value.
     *
     * @return string The value.
     */
    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
