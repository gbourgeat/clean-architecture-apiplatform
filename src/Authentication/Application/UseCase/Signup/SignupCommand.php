<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\Signup;

use App\Common\Application\Command\Command;

final class SignupCommand implements Command
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirm,
    ) {
    }
}
