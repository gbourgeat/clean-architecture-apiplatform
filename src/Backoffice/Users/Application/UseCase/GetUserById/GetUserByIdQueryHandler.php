<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Application\UseCase\GetUserById;

use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Common\Application\Query\QueryHandler;

final class GetUserByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(GetUserByIdQuery $query): ?User
    {
        return $this->userRepository->get($query->userId);
    }
}
