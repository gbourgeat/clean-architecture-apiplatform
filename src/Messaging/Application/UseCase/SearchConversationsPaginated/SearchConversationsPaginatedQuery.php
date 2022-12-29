<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SearchConversationsPaginated;

use App\Common\Application\Query\Query;

final class SearchConversationsPaginatedQuery implements Query
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $itemsPerPage = 20,
    ) {
    }
}
