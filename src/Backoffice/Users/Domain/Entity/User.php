<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Domain\Entity;

use App\Backoffice\Authentication\Domain\Entity\SecurityUser;
use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Backoffice\Users\Domain\ValueObject\HashedPassword;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Backoffice\Users\Domain\ValueObject\UserStatus;
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

    private UserStatus $status;

    private SecurityUser $authUser;

    private Collection $managedWorkspaces;

    private function __construct(
        private FirstName $firstName,
        private LastName $lastName,
        private Email $email,
        AuthPassword $password,
    ) {
        $this->id = UserId::generate();
        $this->status = UserStatus::PENDING_VALIDATE_EMAIL;
        $this->createdAt = DateTime::now();
        $this->authUser = SecurityUser::create(AuthUsername::fromString((string) $email), $password);

        $this->managedWorkspaces = new ArrayCollection();
    }

    public static function create(
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        AuthPassword $password,
    ): User {
        return new self(
            $firstName,
            $lastName,
            $email,
            $password,
        );
    }

    /*
     * ===============================
     * == Getters
     * ===============================
     */

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

    public function status(): UserStatus
    {
        return $this->status;
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

    public function authUser(): SecurityUser
    {
        return $this->authUser;
    }

    public function managedWorkspaces(): Collection
    {
        return $this->managedWorkspaces;
    }

    /*
     * ===============================
     * == Actions
     * ===============================
     */

    public function enable(): void
    {
        $this->ensureIsNotAlreadyEnabled();

        $this->status = UserStatus::ACTIVE;
        $this->enabledAt = DateTime::now();
    }

    public function remove(): void
    {
        $this->ensureIsNotAlreadyRemoved();

        $this->status = UserStatus::REMOVED;
        $this->removedAt = DateTime::now();
    }

    public function changePassword(AuthPassword $newPassword): void
    {
        $this->authUser->changePassword($newPassword);
    }

    /*
     * ===============================
     * == Validators
     * ===============================
     */

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
