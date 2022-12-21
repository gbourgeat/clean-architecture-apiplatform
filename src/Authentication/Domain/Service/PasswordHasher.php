<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Service;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Authentication\Domain\ValueObject\Password;

interface PasswordHasher
{
    public function hash(Password $password): HashedPassword;

    public function verify(HashedPassword $hashedPassword, Password $plainPassword): bool;
}
