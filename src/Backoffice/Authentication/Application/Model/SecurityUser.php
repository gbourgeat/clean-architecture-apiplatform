<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Application\Model;

use App\Backoffice\Users\Domain\Entity\User;

final class SecurityUser
{
    private function __construct()
    {
    }

    public static function fromEntity(User $user): self
    {

    }
}
