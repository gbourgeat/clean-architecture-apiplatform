<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\FirstName;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class FirstNameType extends StringType
{
    public const TYPE = 'firstname';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?FirstName
    {
        if (null === $value) {
            return null;
        }

        return FirstName::fromString((string) $value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
