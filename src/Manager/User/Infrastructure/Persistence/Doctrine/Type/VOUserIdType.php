<?php

declare( strict_types = 1 );

namespace App\Manager\User\Infrastructure\Persistence\Doctrine\Type;

use App\Manager\User\Domain\ValueObject\VOUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class VOUserIdType extends Type {
    public const NAME = 'vo_user_id';

    public function getSQLDeclaration( array $column, AbstractPlatform $platform ): string {
        // Store as GUID/UUID-ish string. Adjust length as needed.
        return $platform->getGuidTypeDeclarationSQL( $column );
    }

    public function convertToDatabaseValue( $value, AbstractPlatform $platform ): ?string {
        if ( $value === null ) {
            return null;
        }

        if ( $value instanceof VOUserId ) {
            return $value->getValue()->toString();
        }

        if ( is_string( $value ) ) {
            return $value;
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            self::NAME,
            [ 'null', VOUserId::class, 'string' ]
        );
    }

    public function convertToPHPValue( $value, AbstractPlatform $platform ): ?VOUserId {
        if ( $value === null || $value instanceof VOUserId ) {
            return $value;
        }

        if ( is_string( $value ) ) {
            return new VOUserId( $value );
        }

        throw ConversionException::conversionFailed( $value, self::NAME );
    }

    public function getName(): string {
        return self::NAME;
    }

    public function requiresSQLCommentHint( AbstractPlatform $platform ): bool {
        // Ensure schema tool recognizes the custom type
        return true;
    }
}
