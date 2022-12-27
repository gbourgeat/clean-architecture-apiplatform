<?php

declare(strict_types=1);

namespace App\Common\UserInterface\Security;

use App\Authentication\Application\DTO\AuthUserDTO;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthUser implements UserInterface
{
    private function __construct(
        private readonly AuthUserDTO $authUser,
    ) {
    }

    public static function fromAuthUserDTO(AuthUserDTO $authUserDTO): self
    {
        return new self($authUserDTO);
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
}
