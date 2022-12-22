<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\Signup;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Domain\Entity\UserCredential;
use App\Authentication\Domain\Repository\UserCredentialRepository;
use App\Authentication\Domain\Service\PasswordHasher;
use App\Authentication\Domain\ValueObject\Password;
use App\Authentication\Domain\ValueObject\Username;
use App\Authentication\Infrastructure\Symfony\Service\TokenService;
use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Application\UseCase\CreateUser\CreateUserCommand;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Command\CommandHandler;

final class SignupCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly PasswordHasher $passwordHasher,
        private readonly UserCredentialRepository $userCredentialRepository,
        private readonly TokenService $tokenService,
    ) {
    }

    public function __invoke(SignupCommand $command): AuthTokenDTO
    {
        if ($command->password !== $command->passwordConfirm) {
            throw new \RuntimeException('Invalid password confirm');
        }

        /** @var UserDTO $userDTO */
        $userDTO = $this->commandBus
            ->dispatch(
                new CreateUserCommand(
                    firstName: $command->firstName,
                    lastName: $command->lastName,
                    email: $command->email,
                )
            );

        $userCredential = UserCredential::create(
            userId: UserId::fromString($userDTO->id),
            username: Username::fromString($command->email),
            hashedPassword: $this->passwordHasher->hash(Password::fromString($command->password)),
        );

        $this->userCredentialRepository->add($userCredential);

        return $this->tokenService->encode(AuthUserDTO::createFromUserDTO($userDTO));
    }
}