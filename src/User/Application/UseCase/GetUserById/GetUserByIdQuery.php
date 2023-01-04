<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\GetUserById;

use App\Common\Application\Query\Query;

final class GetUserByIdQuery implements Query
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
