<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Domain\ValueObject;

use App\Common\Domain\ValueObject\ArrayValue;

final class Roles extends ArrayValue
{
    protected const VALUE_OBJECT_CLASS = Role::class;
}
