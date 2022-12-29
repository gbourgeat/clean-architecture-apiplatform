<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Infrastructure\Doctrine\Type;

use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use App\Common\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class WorkspaceNameType extends StringType
{
    protected const TYPE = 'workspace_name';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return WorkspaceName::fromString((string) $value);
    }
}
