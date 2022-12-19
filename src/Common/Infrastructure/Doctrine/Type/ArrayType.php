<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class ArrayType extends JsonType
{
    protected const TYPE = 'array';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return (string) static::TYPE;
    }
}
