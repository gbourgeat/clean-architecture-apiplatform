<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

final class Role extends StringValue
{
    public const USER = 'ROLE_USER';

    protected function throwExceptionForInvalidValue($value)
    {
        throw new \Exception('Bad value ENUM');
    }
}
