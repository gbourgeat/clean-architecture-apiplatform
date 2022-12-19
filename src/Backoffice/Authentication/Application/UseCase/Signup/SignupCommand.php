<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Application\UseCase\Signup;

use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Common\Application\Command\Command;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;

final class SignupCommand implements Command
{
    public function __construct(
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly AuthUsername $email,
        public readonly AuthPassword $password,
        public readonly AuthPassword $passwordConfirm,
    ) {
    }
}
