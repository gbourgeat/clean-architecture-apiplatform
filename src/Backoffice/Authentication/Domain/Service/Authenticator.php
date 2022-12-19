<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Domain\Service;

use App\Backoffice\Authentication\Domain\Exception\InvalidCredentials;
use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;

interface Authenticator
{
    /**
     * @throws InvalidCredentials
     */
    public function authenticate(AuthUsername $username, AuthPassword $password): void;
}
