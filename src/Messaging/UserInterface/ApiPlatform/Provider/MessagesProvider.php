<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Messaging\Application\DTO\MessageDTO;
use App\Messaging\Application\UseCase\GetMessages\GetMessagesQuery;
use App\Messaging\UserInterface\ApiPlatform\Resource\MessageResource;

/**
 * @template-implements ProviderInterface<MessageResource>
 */
class MessagesProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    /**
     * @return MessageResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $conversationId = (string) $uriVariables['id'];
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);
        $messagesDTOs = $this->getMessagesDTOs($conversationId, $page, $itemsPerPage);

        return $this->mapMessagesDTOsToMessagesResources($messagesDTOs);
    }

    /**
     * @return MessageDTO[]
     */
    private function getMessagesDTOs(string $conversationId, int $page, int $itemsPerPage): array
    {
        return $this->queryBus
            ->ask(
                new GetMessagesQuery(
                    conversationId: $conversationId,
                    page: $page,
                    itemsPerPage: $itemsPerPage,
                )
            );
    }

    /**
     * @return MessageResource[]
     */
    private function mapMessagesDTOsToMessagesResources(array $messagesDTOs): array
    {
        return array_map(static function (MessageDTO $messageDTO) {
            return MessageResource::fromMessageDTO($messageDTO);
        }, $messagesDTOs);
    }
}
