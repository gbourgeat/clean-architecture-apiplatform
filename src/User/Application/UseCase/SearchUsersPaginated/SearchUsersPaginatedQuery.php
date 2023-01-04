<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\SearchUsersPaginated;

use App\Common\Application\Query\Query;

final class SearchUsersPaginatedQuery implements Query
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $itemsPerPage = 20,
    ) {
    }
}
