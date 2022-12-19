<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\TextType;
use App\Messaging\Domain\ValueObject\MessageContent;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class MessageContentType extends TextType
{
    public const TYPE = 'message_content';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MessageContent
    {
        if (null === $value) {
            return null;
        }

        return MessageContent::fromString((string) $value);
    }
}
