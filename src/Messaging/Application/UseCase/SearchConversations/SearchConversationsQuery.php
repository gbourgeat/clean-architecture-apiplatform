<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SearchConversations;

use App\Common\Application\Query\Query;

final class SearchConversationsQuery implements Query
{
    public function __construct(
        public readonly int $limit,
        public readonly string $field,
        public readonly string $direction,
        public readonly ?string $cursor = null,
    ) {
    }
}
