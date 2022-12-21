<?php

declare(strict_types=1);

namespace App\Backoffice\User\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Authentication\Application\UseCase\Signup\SignupCommand;
use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\UserInterface\ApiPlatform\Resource\UserResource;
use App\Common\Application\Command\CommandBus;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;
use Webmozart\Assert\Assert;

class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UserResource
    {
        Assert::isInstanceOf($data, UserResource::class);
        /** @var UserResource $userResource */
        $userResource = $data;

        /** @var User $user */
        $user = $this->commandBus
            ->dispatch(
                new SignupCommand(
                    firstName: FirstName::fromString($userResource->firstName),
                    lastName: LastName::fromString($userResource->lastName),
                    email: Email::fromString($userResource->email),
                )
            );

        return UserResource::fromEntity($user);
    }
}
