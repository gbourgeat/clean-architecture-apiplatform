<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Domain\Entity;

use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceId;
use App\Backoffice\Workspace\Domain\ValueObject\WorkspaceName;
use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Email;

class Workspace extends AggregateRoot
{
    private WorkspaceId $id;

    private DateTime $createdAt;

    private function __construct(
        private WorkspaceName $name,
        private Email $contactEmail,
        private User $owner,
    ) {
        $this->id = WorkspaceId::generate();
        $this->createdAt = DateTime::now();
    }

    public static function create(
        WorkspaceName $name,
        Email $contactEmail,
        User $owner,
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

    public function owner(): User
    {
        return $this->owner;
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
