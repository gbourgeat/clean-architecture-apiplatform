<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Infrastructure\Doctrine\Type;

use App\Backoffice\Users\Domain\ValueObject\HashedPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class HashedPasswordType extends StringType
{
    public const TYPE = 'hashed_password';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?HashedPassword
    {
        if (null === $value) {
            return null;
        }

        return HashedPassword::fromString((string) $value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
