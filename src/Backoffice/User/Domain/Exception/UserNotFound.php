<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain\Exception;

use App\Common\Domain\Exception\ResourceNotFound;

abstract class UserNotFound extends ResourceNotFound
{
}
