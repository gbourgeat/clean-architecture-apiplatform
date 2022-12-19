<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType as DoctrineStringType;

abstract class StringType extends DoctrineStringType
{
    protected const TYPE = 'string';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return (string) static::TYPE;
    }
}
