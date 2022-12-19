<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Infrastructure\Doctrine\Type;

use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class WorkspaceNameType extends StringType
{
    protected const TYPE = 'workspace_name';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return WorkspaceName::fromString((string) $value);
    }
}
