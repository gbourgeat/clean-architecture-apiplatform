<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\GetFromToken;

use App\Common\Application\Query\Query;

final class GetFromTokenQuery implements Query
{
    public function __construct(
        public readonly string $token,
    ) {
    }
}
