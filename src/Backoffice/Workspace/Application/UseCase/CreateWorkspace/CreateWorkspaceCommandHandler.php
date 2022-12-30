<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Application\UseCase\CreateWorkspace;

use App\Authentication\Application\DTO\AuthUserDTO;
use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Application\UseCase\GetUserById\GetUserByIdQuery;
use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Backoffice\Workspace\Domain\Repository\WorkspaceRepository;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Query\QueryBus;
use App\Common\Application\Session\Security;
use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\Email;

final class CreateWorkspaceCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly WorkspaceRepository $workspaceRepository,
        private readonly QueryBus $queryBus,
        private readonly Security $security,
    ) {
    }

    /**
     * @throws InvalidFormat
     */
    public function __invoke(CreateWorkspaceCommand $command): Workspace
    {
        $contactEmail = Email::fromString($this->security->connectedUser()->email);
        $owner = $this->getUserDTOFromAuthUserDTO($this->security->connectedUser());

        $workspace = Workspace::create(
            name: WorkspaceName::fromString($command->name),
            contactEmail: $contactEmail,
            owner: $owner,
        );

        $this->workspaceRepository->add($workspace);

        return $workspace;
    }

    private function getUserDTOFromAuthUserDTO(AuthUserDTO $authUserDTO): UserDTO
    {
        return $this->queryBus
            ->ask(
                new GetUserByIdQuery(
                    userId: $authUserDTO->userId,
                )
            );
    }
}
