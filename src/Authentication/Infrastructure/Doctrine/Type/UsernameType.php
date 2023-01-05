<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Doctrine\Type;

use App\Authentication\Domain\ValueObject\Username;
use App\Common\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class UsernameType extends StringType
{
    public const TYPE = 'username';

    public function convertToPHPValue($value, AbstractPlatform $platform): Username
    {
        return Username::fromString((string) $value);
    }
}
