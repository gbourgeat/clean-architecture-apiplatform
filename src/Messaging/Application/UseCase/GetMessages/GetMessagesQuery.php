<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\GetMessages;

use App\Common\Application\Query\Query;

final class GetMessagesQuery implements Query
{
    public function __construct(
        public readonly string $conversationId,
        public readonly int $page = 1,
        public readonly int $itemsPerPage = 20,
    ) {
    }
}
