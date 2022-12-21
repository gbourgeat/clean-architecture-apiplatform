<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\UseCase\GetUserWithEmail;

use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Common\Application\Query\QueryHandler;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final class GetUserWithEmailQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(GetUserWithEmailQuery $query): ?User
    {
        try {
            return $this->userRepository->getByEmail($query->email);
        } catch (UserNotFoundException $exception) {
            return null;
        }
    }
}
