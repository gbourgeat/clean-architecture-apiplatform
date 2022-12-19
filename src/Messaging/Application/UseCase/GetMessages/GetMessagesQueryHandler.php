<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\GetMessages;

use App\Messaging\Domain\Repository\MessageRepository;
use App\Common\Application\Query\QueryHandler;

final class GetMessagesQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly MessageRepository $messageRepository
    ) {
    }

    public function __invoke(GetMessagesQuery $query): MessageRepository
    {
        return $this->messageRepository
            ->withConversationId($query->conversationId)
            ->withPagination($query->page, $query->itemsPerPage);
    }
}
