<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\GetConversation;

use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Exception\ConversationNotFound;
use App\Messaging\Domain\Repository\ConversationRepository;
use App\Common\Application\Query\QueryHandler;

final class GetConversationQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository
    ) {
    }

    /**
     * @throws ConversationNotFound
     */
    public function __invoke(GetConversationQuery $query): Conversation
    {
        return $this->conversationRepository->get($query->conversationId);
    }
}
