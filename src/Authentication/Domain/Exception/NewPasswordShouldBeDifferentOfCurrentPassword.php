<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

final class NewPasswordShouldBeDifferentOfCurrentPassword extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The new password must be different of current password.');
    }
}
