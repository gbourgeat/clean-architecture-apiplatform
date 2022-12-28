<?php

declare(strict_types=1);

namespace App\Common\Application\Session;

use App\Authentication\Application\DTO\AuthUserDTO;

interface Security
{
    public function isAuthenticated(): bool;

    public function connectedUser(): ?AuthUserDTO;
}
