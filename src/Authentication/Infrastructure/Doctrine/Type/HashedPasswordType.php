<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Doctrine\Type;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Common\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class HashedPasswordType extends StringType
{
    public const TYPE = 'hashed_password';

    public function convertToPHPValue($value, AbstractPlatform $platform): HashedPassword
    {
        return HashedPassword::fromString((string) $value);
    }
}
