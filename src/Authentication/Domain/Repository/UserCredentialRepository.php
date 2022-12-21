<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Repository;

use App\Authentication\Domain\Entity\UserCredential;
use App\Authentication\Domain\ValueObject\Username;

interface UserCredentialRepository
{
    public function getByUsername(Username $username): UserCredential;

    public function add(UserCredential $userCredential): void;
}
