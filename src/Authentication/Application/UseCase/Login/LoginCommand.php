<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\Login;

use App\Common\Application\Command\Command;

final class LoginCommand implements Command
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
    ) {
    }
}
