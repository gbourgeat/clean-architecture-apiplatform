<?php

declare(strict_types=1);

namespace App\User\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Common\Domain\Exception\InvalidFormat;
use App\User\Application\DTO\UserDTO;
use App\User\Application\UseCase\CreateUser\CreateUserCommand;
use App\User\Domain\Exception\EmailAlreadyUsed;
use App\User\UserInterface\ApiPlatform\Resource\UserResource;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Webmozart\Assert\Assert;

final class CreateUserProcessor implements ProcessorInterface
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

        try {
            $userDTO = $this->createUserAndReturnUserDTO($userResource);
        } catch (EmailAlreadyUsed|InvalidFormat $exception) {
            throw new BadRequestException($exception->getMessage());
        }

        return UserResource::fromUserDTO($userDTO);
    }

    /**
     * @throws EmailAlreadyUsed|InvalidFormat
     */
    private function createUserAndReturnUserDTO(UserResource $userResource): UserDTO
    {
        return $this->commandBus
            ->dispatch(
                new CreateUserCommand(
                    firstName: $userResource->firstName,
                    lastName: $userResource->lastName,
                    email: $userResource->email,
                )
            );
    }
}
