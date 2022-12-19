<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Infrastructure\Doctrine\Type;

use App\Backoffice\Users\Domain\ValueObject\ExternalId;
use App\Common\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ExternalIdType extends UuidType
{
    public const TYPE = 'external_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? ExternalId::fromString((string) $value) : null;
    }
}
