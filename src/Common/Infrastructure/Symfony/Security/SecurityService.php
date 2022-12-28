<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Security;

use App\Authentication\Application\DTO\AuthUserDTO;
use App\Common\Application\Session\Security;
use Symfony\Component\Security\Core\Security as SecurityComponent;
use App\Common\UserInterface\Security\AuthUser;

final class SecurityService implements Security
{
    public function __construct(
        private readonly SecurityComponent $security,
    ) {
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->connectedUser();
    }

    public function connectedUser(): ?AuthUserDTO
    {
        $authenticatedUser = $this->security->getUser();

        if (!$authenticatedUser instanceof AuthUser) {
            return null;
        }

        return $authenticatedUser->authUserDTO();
    }
}
