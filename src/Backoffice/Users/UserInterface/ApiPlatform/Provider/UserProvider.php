<?php

declare(strict_types=1);

namespace App\Backoffice\Users\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Backoffice\Users\Application\UseCase\GetUserById\GetUserByIdQuery;
use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Backoffice\Users\UserInterface\ApiPlatform\Resource\UserResource;
use App\Common\Application\Query\QueryBus;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            /** @var ?User $user */
            $user = $this->queryBus->ask(new GetUserByIdQuery(UserId::fromString((string) $uriVariables['id'])));
        } catch (\InvalidArgumentException $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

        return null !== $user ? UserResource::fromEntity($user) : null;
    }
}
