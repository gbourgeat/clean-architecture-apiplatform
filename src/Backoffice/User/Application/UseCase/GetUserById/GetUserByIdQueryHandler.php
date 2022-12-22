<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\UseCase\GetUserById;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\Exception\UserNotFound;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Common\Application\Query\QueryHandler;

final class GetUserByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(GetUserByIdQuery $query): ?UserDTO
    {
        $user = $this->userRepository->get(UserId::fromString($query->userId));

        return UserDTO::fromEntity($user);
    }
}
