<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SearchConversationsPaginated;

use App\Common\Application\Query\QueryHandler;
use App\Messaging\Application\DTO\ConversationDTO;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Repository\ConversationRepository;

final class SearchConversationsPaginatedQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
    ) {
    }

    public function __invoke(SearchConversationsPaginatedQuery $query): array
    {
        $users = $this->conversationRepository->search($query->page, $query->itemsPerPage);

        return $this->mapConversationsToConversationsDTOs($users);
    }

    /**
     * @param Conversation[] $conversations
     * @return ConversationDTO[]
     */
    private function mapConversationsToConversationsDTOs(array $conversations): array
    {
        return array_map(static function (Conversation $conversation) {
            return ConversationDTO::fromEntity($conversation);
        }, $conversations);
    }
}
