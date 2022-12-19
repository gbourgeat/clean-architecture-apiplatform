<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Application\UseCase\Login;

use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Common\Application\Command\Command;

final class LoginCommand implements Command
{
    public function __construct(
        public readonly AuthUsername $username,
        public readonly AuthPassword $password,
    ) {
    }
}
