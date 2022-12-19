<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EmailType extends StringType
{
    public const TYPE = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if (null === $value) {
            return null;
        }

        return Email::fromString((string) $value);
    }
}
