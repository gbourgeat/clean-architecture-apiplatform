<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Infrastructure\Doctrine\Type;

use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceId;
use App\Common\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class WorkspaceIdType extends UuidType
{
    protected const TYPE = 'workspace_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return WorkspaceId::fromString((string) $value);
    }
}
