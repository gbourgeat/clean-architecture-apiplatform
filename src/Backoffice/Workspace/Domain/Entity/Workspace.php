<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Domain\Entity;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceId;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Email;

class Workspace extends AggregateRoot
{
    private WorkspaceId $id;

    private DateTime $createdAt;

    private UserId $ownerId;

    private function __construct(
        private WorkspaceName $name,
        private Email $contactEmail,
        UserDTO $ownerDTO,
    ) {
        $this->id = WorkspaceId::generate();
        $this->createdAt = DateTime::now();
        $this->ownerId = UserId::fromString($ownerDTO->id);
    }

    public static function create(
        WorkspaceName $name,
        Email $contactEmail,
        UserDTO $owner,
    ): Workspace {
        return new self(
            $name,
            $contactEmail,
            $owner,
        );
    }

    public function id(): WorkspaceId
    {
        return $this->id;
    }

    public function name(): WorkspaceName
    {
        return $this->name;
    }

    public function ownerId(): UserId
    {
        return $this->ownerId;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function contactEmail(): Email
    {
        return $this->contactEmail;
    }
}
