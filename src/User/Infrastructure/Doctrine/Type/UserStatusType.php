<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\ValueObject\UserStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Webmozart\Assert\Assert;

class UserStatusType extends StringType
{
    public const TYPE = 'user_status';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserStatus
    {
        if (null === $value) {
            return null;
        }

        return UserStatus::tryFrom((string) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        Assert::isInstanceOf($value, UserStatus::class);
        /** @var UserStatus $userStatus */
        $userStatus = $value;

        return $userStatus->value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
