<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Messaging\Domain\ValueObject\ParticipantName;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ParticipantNameType extends StringType
{
    public const TYPE = 'participant_name';

    public function convertToPHPValue($value, AbstractPlatform $platform): ParticipantName
    {
        return ParticipantName::fromString((string) $value);
    }
}
