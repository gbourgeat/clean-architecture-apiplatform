<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Infrastructure\Symfony\Security;

use App\Backoffice\Authentication\Domain\Entity\SecurityUser;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Auth implements UserInterface, PasswordHasherAwareInterface
{
    public const PASSWORD_HASHER_ALGORITHM = 'bcrypt';

    private function __construct(
        private readonly SecurityUser $authUser,
    ) {
    }

    public static function fromAuthUser(SecurityUser $authUser): self
    {
        return new self($authUser);
    }

    public function getRoles(): array
    {
        return $this->authUser->roles();
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->authUser->username();
    }

    public function getPasswordHasherName(): ?string
    {
        return self::PASSWORD_HASHER_ALGORITHM;
    }
}
