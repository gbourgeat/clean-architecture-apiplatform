<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Application\UseCase\SearchUsersPaginated;

use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Common\Application\Query\QueryHandler;

final class SearchUsersPaginatedQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(SearchUsersPaginatedQuery $query): UserRepository
    {
        return $this->userRepository->withPagination($query->page, $query->itemsPerPage);
    }
}
