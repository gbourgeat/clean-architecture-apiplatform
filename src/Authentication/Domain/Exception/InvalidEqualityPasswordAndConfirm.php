<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Common\Domain\Exception\ValidationFailed;

final class InvalidEqualityPasswordAndConfirm extends ValidationFailed
{
    public function __construct()
    {
        parent::__construct('The confirm password is not equal to password.');
    }
}
