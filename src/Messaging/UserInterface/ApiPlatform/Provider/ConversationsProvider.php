<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Common\Domain\Repository\CursorPagination;
use App\Common\UserInterface\ApiPlatform\Paginator\CursorResult;
use App\Messaging\Application\UseCase\SearchConversations\SearchConversationsQuery;
use App\Messaging\UserInterface\ApiPlatform\Resource\ConversationResource;

final class ConversationsProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CursorResult
    {
        $resultLimit = $operation->getPaginationItemsPerPage();

        /** @var CursorPagination $cursorPagination */
        $cursorPagination = $this->queryBus
            ->ask(
                new SearchConversationsQuery(
                    5,
                    $operation->getPaginationViaCursor()[0]['field'],
                    $operation->getPaginationViaCursor()[0]['direction'],
                    array_key_exists('filters', $context) && array_key_exists('cursor', $context['filters'])  ? $context['filters']['cursor'] : null
                )
            );

        $resources = [];
        foreach ($cursorPagination as $entity) {
            $resources[] = ConversationResource::fromEntity($entity);
        }

        return new CursorResult($resources, (string) $cursorPagination->prevCursor(), (string) $cursorPagination->nextCursor());
    }
}
