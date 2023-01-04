<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\CreateUser;

use App\Common\Application\Command\Command;

final class CreateUserCommand implements Command
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
    ) {
    }
}
