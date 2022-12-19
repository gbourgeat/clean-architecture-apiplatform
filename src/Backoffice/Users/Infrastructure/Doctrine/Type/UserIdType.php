<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Infrastructure\Doctrine\Type;

use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class UserIdType extends UuidType
{
    public const TYPE = 'user_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::fromString((string) $value);
    }
}
