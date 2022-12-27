<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\GetAuthUserFromToken;

use App\Common\Application\Query\Query;

final class GetAuthUserFromTokenQuery implements Query
{
    public function __construct(
        public readonly string $token,
    ) {
    }
}
