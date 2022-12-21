<?php

declare(strict_types=1);

namespace App\Common\Application\Session;

interface Auth
{
    public function isAuthenticated(): bool;
}
