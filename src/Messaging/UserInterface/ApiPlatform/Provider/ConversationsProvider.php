<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Messaging\Application\DTO\ConversationDTO;
use App\Messaging\Application\UseCase\SearchConversationsPaginated\SearchConversationsPaginatedQuery;
use App\Messaging\UserInterface\ApiPlatform\Resource\ConversationResource;

/**
 * @template-implements ProviderInterface<ConversationResource>
 */
final class ConversationsProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);

        $conversations = $this->getConversationsDTOs($page, $itemsPerPage);

        return $this->mapConversationDTOsToConversationsResources($conversations);
    }

    /**
     * @return ConversationDTO[]
     */
    private function getConversationsDTOs(int $page, int $itemsPerPage): array
    {
        return $this->queryBus->ask(new SearchConversationsPaginatedQuery($page, $itemsPerPage));
    }

    /**
     * @return ConversationResource[]
     */
    private function mapConversationDTOsToConversationsResources(array $conversationsDTOs): array
    {
        return array_map(static function (ConversationDTO $conversationDTO) {
            return ConversationResource::fromConversationDTO($conversationDTO);
        }, $conversationsDTOs);
    }
}
