<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain\ValueObject;

use App\Common\Domain\ValueObject\ArrayValue;

final class Roles extends ArrayValue
{
    protected const VALUE_OBJECT_CLASS = Role::class;
}
