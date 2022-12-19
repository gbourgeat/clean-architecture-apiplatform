<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SearchConversations;

use App\Common\Domain\Repository\CursorPagination;
use App\Messaging\Domain\Repository\ConversationRepository;
use App\Common\Application\Query\QueryHandler;

final class SearchConversationsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
    ) {
    }

    public function __invoke(SearchConversationsQuery $query): CursorPagination
    {
        return $this->conversationRepository->listCursorPagination($query->limit, $query->field, $query->direction, $query->cursor);
    }
}
