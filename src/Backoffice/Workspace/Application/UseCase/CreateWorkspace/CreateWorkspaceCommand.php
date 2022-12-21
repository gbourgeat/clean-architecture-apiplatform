<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Application\UseCase\CreateWorkspace;

use App\Common\Application\Command\Command;

final class CreateWorkspaceCommand implements Command
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}
