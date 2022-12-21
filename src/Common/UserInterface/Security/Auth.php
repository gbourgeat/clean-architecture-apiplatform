<?php

declare(strict_types=1);

namespace App\Common\UserInterface\Security;

use App\Authentication\Application\DTO\AuthUserDTO;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Auth implements UserInterface, PasswordHasherAwareInterface
{
    public const PASSWORD_HASHER_ALGORITHM = 'bcrypt';

    private function __construct(
        private readonly AuthUserDTO $authUser,
    ) {
    }

    public static function fromAuthUser(AuthUserDTO $authUser): self
    {
        return new self($authUser);
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->authUser->userId;
    }

    public function getPasswordHasherName(): ?string
    {
        return self::PASSWORD_HASHER_ALGORITHM;
    }
}
