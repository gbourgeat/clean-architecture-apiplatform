<?php

declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

final class Username extends StringValue
{
    public function isEmail(): bool
    {
        return (bool) filter_var($this->value(), FILTER_VALIDATE_EMAIL);
    }
}
