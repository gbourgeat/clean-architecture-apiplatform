<?php

declare(strict_types=1);

namespace App\Backoffice\Users\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Backoffice\Users\Application\UseCase\SearchUsersPaginated\SearchUsersPaginatedQuery;
use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Backoffice\Users\UserInterface\ApiPlatform\Resource\UserResource;
use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\ApiPlatform\Model\Paginator;

class UsersProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);

        /** @var UserRepository $userRepository */
        $userRepository = $this->queryBus->ask(new SearchUsersPaginatedQuery($page, $itemsPerPage));

        $resources = [];
        foreach ($userRepository as $entity) {
            $resources[] = UserResource::fromEntity($entity);
        }

        if (null !== $paginator = $userRepository->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                $paginator->getCurrentPage(),
                $paginator->getItemsPerPage(),
                $paginator->getLastPage(),
                $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
