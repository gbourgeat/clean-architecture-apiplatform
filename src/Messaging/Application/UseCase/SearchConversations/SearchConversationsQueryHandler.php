<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SearchConversations;

use App\Common\Application\Query\QueryHandler;

final class SearchConversationsQueryHandler implements QueryHandler
{
    public function __invoke(SearchConversationsQuery $query): array
    {
        return [];
    }
}
