<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Application\UseCase\GetUserWithEmail;

use App\Common\Application\Query\Query;
use App\Common\Domain\ValueObject\Email;

final class GetUserWithEmailQuery implements Query
{
    public function __construct(
        public readonly Email $email
    ) {
    }
}
