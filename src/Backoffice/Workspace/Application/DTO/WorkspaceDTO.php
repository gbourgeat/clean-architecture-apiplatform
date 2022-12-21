<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Application\DTO;

use App\Backoffice\Workspace\Domain\Entity\Workspace;

final class WorkspaceDTO
{
    private function __construct(
        public readonly string $name,
    ) {
    }

    public static function fromEntity(Workspace $workspace): WorkspaceDTO
    {
        return new self(
            name: (string) $workspace->name(),
        );
    }
}
