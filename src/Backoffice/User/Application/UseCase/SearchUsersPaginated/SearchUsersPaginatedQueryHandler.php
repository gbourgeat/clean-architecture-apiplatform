<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\UseCase\SearchUsersPaginated;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Common\Application\Query\QueryHandler;

final class SearchUsersPaginatedQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(SearchUsersPaginatedQuery $query): array
    {
        $users = $this->userRepository->search($query->page, $query->itemsPerPage);

        return $this->mapUsersToUsersDTOs($users);
    }

    /**
     * @param User[] $users
     * @return UserDTO[]
     */
    private function mapUsersToUsersDTOs(array $users): array
    {
        return array_map(static function (User $user) {
            return UserDTO::fromEntity($user);
        }, $users);
    }
}
