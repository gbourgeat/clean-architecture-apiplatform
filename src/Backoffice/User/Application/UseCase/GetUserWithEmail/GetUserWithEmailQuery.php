<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\UseCase\GetUserWithEmail;

use App\Common\Application\Query\Query;

final class GetUserWithEmailQuery implements Query
{
    public function __construct(
        public readonly string $email
    ) {
    }
}
