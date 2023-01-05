<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Type;

use App\Messaging\Domain\ValueObject\MessageId;
use App\Common\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class MessageIdType extends UuidType
{
    public const TYPE = 'message_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): MessageId
    {
        return MessageId::fromString((string) $value);
    }
}
