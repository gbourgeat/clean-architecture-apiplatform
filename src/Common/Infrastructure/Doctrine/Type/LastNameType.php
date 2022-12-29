<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\LastName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class LastNameType extends StringType
{
    public const TYPE = 'lastname';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?LastName
    {
        if (null === $value) {
            return null;
        }

        return LastName::fromString((string) $value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
