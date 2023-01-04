<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\User\Domain\ValueObject\UserId;

final class UserNotFoundWithId extends UserNotFound
{
    public function __construct(UserId $userId)
    {
        parent::__construct(sprintf('User not found with id "%s".', (string) $userId));
    }
}
