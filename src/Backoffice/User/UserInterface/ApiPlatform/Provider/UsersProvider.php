<?php

declare(strict_types=1);

namespace App\Backoffice\User\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Application\UseCase\SearchUsersPaginated\SearchUsersPaginatedQuery;
use App\Backoffice\User\UserInterface\ApiPlatform\Resource\UserResource;
use App\Common\Application\Query\QueryBus;

/**
 * @template-implements ProviderInterface<UserResource>
 */
final class UsersProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    /**
     * @return UserResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);

        $users = $this->getUsersDTOs($page, $itemsPerPage);

        return $this->mapUserDTOsToUsersResources($users);
    }

    /**
     * @return UserDTO[]
     */
    private function getUsersDTOs(int $page, int $itemsPerPage): array
    {
        return $this->queryBus->ask(new SearchUsersPaginatedQuery($page, $itemsPerPage));
    }

    /**
     * @return UserResource[]
     */
    private function mapUserDTOsToUsersResources(array $usersDTOs): array
    {
        $resources = [];
        foreach ($usersDTOs as $userDTO) {
            $resources[] = UserResource::fromUserDTO($userDTO);
        }

        return $resources;
    }
}
