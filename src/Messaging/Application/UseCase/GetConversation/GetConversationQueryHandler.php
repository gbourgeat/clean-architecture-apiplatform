<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\GetConversation;

use App\Messaging\Application\DTO\ConversationDTO;
use App\Messaging\Domain\Exception\ConversationNotFound;
use App\Messaging\Domain\Repository\ConversationRepository;
use App\Common\Application\Query\QueryHandler;
use App\Messaging\Domain\ValueObject\ConversationId;

final class GetConversationQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
    ) {
    }

    /**
     * @throws ConversationNotFound
     */
    public function __invoke(GetConversationQuery $query): ConversationDTO
    {
        $conversation = $this->conversationRepository->get(ConversationId::fromString($query->conversationId));

        return ConversationDTO::fromEntity($conversation);
    }
}
