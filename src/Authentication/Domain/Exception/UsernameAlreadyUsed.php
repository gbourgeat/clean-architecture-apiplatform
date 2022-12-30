<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Authentication\Domain\ValueObject\Username;
use App\Common\Domain\Exception\ValidationFailed;

final class UsernameAlreadyUsed extends ValidationFailed
{
    public function __construct(Username $username)
    {
        parent::__construct(sprintf('Username "%s" already used.', (string) $username));
    }
}
