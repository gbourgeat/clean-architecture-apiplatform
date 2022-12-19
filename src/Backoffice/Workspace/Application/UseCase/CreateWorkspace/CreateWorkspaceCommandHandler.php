<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Application\UseCase\CreateWorkspace;

use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Backoffice\Workspace\Domain\Repository\WorkspaceRepository;
use App\Common\Application\Command\CommandHandler;

final class CreateWorkspaceCommandHandler implements CommandHandler
{
    public function __construct(
        private WorkspaceRepository $workspaceRepository,
    ) {
    }

    public function __invoke(CreateWorkspaceCommand $command): Workspace
    {
        $workspace = Workspace::create(
            $command->name,
        );

        $this->workspaceRepository->save($workspace);

        return $workspace;
    }
}
