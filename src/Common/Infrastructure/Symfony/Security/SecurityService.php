<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Security;

use App\Common\Application\Session\Security;
use App\Common\UserInterface\Security\AuthUser;

final class SecurityService implements Security
{
    public function __construct(
        private readonly \Symfony\Component\Security\Core\Security $security,
    ) {
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->connectedUser();
    }

    public function connectedUser(): ?AuthUser
    {
        $authenticatedUser = $this->security->getUser();

        if (!$authenticatedUser instanceof AuthUser) {
            return null;
        }

        return $authenticatedUser;
    }
}
