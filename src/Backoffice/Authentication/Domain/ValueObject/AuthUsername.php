<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

final class AuthUsername extends StringValue
{
    public function isEmail(): bool
    {
        return (bool) filter_var($this->value(), FILTER_VALIDATE_EMAIL);
    }
}
