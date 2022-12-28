<?php

declare(strict_types=1);

namespace App\Common\Application\Session;

use App\Common\UserInterface\Security\AuthUser;

interface Security
{
    public function isAuthenticated(): bool;

    public function connectedUser(): ?AuthUser;
}
