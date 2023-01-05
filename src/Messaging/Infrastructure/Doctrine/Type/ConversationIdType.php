<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Type;

use App\Messaging\Domain\ValueObject\ConversationId;
use App\Common\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ConversationIdType extends UuidType
{
    public const TYPE = 'conversation_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ConversationId
    {
        return ConversationId::fromString((string) $value);
    }
}
