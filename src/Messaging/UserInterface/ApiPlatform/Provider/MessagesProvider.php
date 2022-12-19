<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\ApiPlatform\Model\Paginator;
use App\Messaging\Application\UseCase\GetMessages\GetMessagesQuery;
use App\Messaging\Domain\Repository\MessageRepository;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\UserInterface\ApiPlatform\Resource\MessageResource;

class MessagesProvider implements ProviderInterface
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

        /** @var MessageRepository $messageRepository */
        $messageRepository = $this->queryBus
            ->ask(
                new GetMessagesQuery(
                    ConversationId::fromString((string) $uriVariables['id']),
                    $page,
                    $itemsPerPage
                )
            );

        $resources = [];
        foreach ($messageRepository as $entity) {
            $resources[] = MessageResource::fromEntity($entity);
        }

//        if (null !== $paginator = $messageRepository->paginator()) {
//            $resources = new Paginator(
//                new \ArrayIterator($resources),
//                $paginator->getCurrentPage(),
//                $paginator->getItemsPerPage(),
//                $paginator->getLastPage(),
//                $paginator->getTotalItems(),
//            );
//        }

        return $resources;
    }
}
