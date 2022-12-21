<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

final class InvalidEqualityPasswordAndConfirm extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The confirm password is not equal to password.');
    }
}
