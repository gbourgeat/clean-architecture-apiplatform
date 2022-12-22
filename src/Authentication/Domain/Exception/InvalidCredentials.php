<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Common\Domain\Exception\ValidationFailed;

final class InvalidCredentials extends ValidationFailed
{
    public function __construct()
    {
        parent::__construct('Username or password are incorrect.');
    }
}
