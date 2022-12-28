<?php

declare(strict_types=1);

namespace App\Backoffice\User\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Application\UseCase\GetUserById\GetUserByIdQuery;
use App\Backoffice\User\Domain\Exception\UserNotFound;
use App\Backoffice\User\UserInterface\ApiPlatform\Resource\UserResource;
use App\Common\Application\Query\QueryBus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class UserProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            $userId = (string) $uriVariables['id'];
            $userDTO = $this->getUserById($userId);
        } catch (UserNotFound $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        return UserResource::fromUserDTO($userDTO);
    }

    /**
     * @throws UserNotFound
     */
    private function getUserById(string $userId): UserDTO
    {
        return $this->queryBus->ask(new GetUserByIdQuery($userId));
    }
}
