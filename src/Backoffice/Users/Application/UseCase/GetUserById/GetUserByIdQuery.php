<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Application\UseCase\GetUserById;

use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Application\Query\Query;

final class GetUserByIdQuery implements Query
{
    public function __construct(
        public readonly UserId $userId,
    ) {
    }
}
