<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Application\UseCase\CreateWorkspace;

use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Backoffice\Workspace\Domain\Repository\WorkspaceRepository;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use App\Common\Application\Command\CommandHandler;

final class CreateWorkspaceCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly WorkspaceRepository $workspaceRepository,
    ) {
    }

    public function __invoke(CreateWorkspaceCommand $command): Workspace
    {
        $workspace = Workspace::create(WorkspaceName::fromString($command->name));

        $this->workspaceRepository->add($workspace);

        return $workspace;
    }
}
