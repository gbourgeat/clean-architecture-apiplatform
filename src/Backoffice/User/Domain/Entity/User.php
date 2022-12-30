<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain\Entity;

use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User extends AggregateRoot
{
    private readonly UserId $id;

    private DateTime $createdAt;

    private ?DateTime $enabledAt = null;

    private ?DateTime $removedAt = null;

    private Collection $managedWorkspaces;

    private function __construct(
        private FirstName $firstName,
        private LastName $lastName,
        private Email $email,
    ) {
        $this->id = UserId::generate();
        $this->createdAt = DateTime::now();

        $this->managedWorkspaces = new ArrayCollection();
    }

    public static function create(
        FirstName $firstName,
        LastName $lastName,
        Email $email,
    ): User {
        return new self(
            $firstName,
            $lastName,
            $email,
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function isEnabled(): bool
    {
        return null !== $this->enabledAt;
    }

    public function isRemoved(): bool
    {
        return null !== $this->removedAt;
    }

    public function managedWorkspaces(): Collection
    {
        return $this->managedWorkspaces;
    }

    public function enable(): void
    {
        $this->ensureIsNotAlreadyEnabled();

        $this->enabledAt = DateTime::now();
    }

    public function remove(): void
    {
        $this->ensureIsNotAlreadyRemoved();

        $this->removedAt = DateTime::now();
    }

    private function ensureIsNotAlreadyEnabled(): void
    {
        if ($this->isEnabled()) {
            throw new \RuntimeException('User is already enabled !');
        }
    }

    private function ensureIsNotAlreadyRemoved(): void
    {
        if ($this->isRemoved()) {
            throw new \RuntimeException('User is already removed !');
        }
    }
}
