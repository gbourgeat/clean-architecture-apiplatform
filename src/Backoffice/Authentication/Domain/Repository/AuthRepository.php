<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Domain\Repository;

use App\Backoffice\Authentication\Domain\Entity\SecurityUser;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;

interface AuthRepository
{
    public function getByUsername(AuthUsername $username): SecurityUser;
}
