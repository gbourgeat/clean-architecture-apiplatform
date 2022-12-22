<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Common\Domain\Exception\ValidationFailed;

final class NewPasswordShouldBeDifferentOfCurrentPassword extends ValidationFailed
{
    public function __construct()
    {
        parent::__construct('The new password must be different of current password.');
    }
}
