<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\Login;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Domain\Exception\InvalidCredentials;
use App\Authentication\Domain\Repository\UserCredentialRepository;
use App\Authentication\Domain\Service\PasswordHasher;
use App\Authentication\Domain\ValueObject\Password;
use App\Authentication\Domain\ValueObject\Username;
use App\Authentication\Infrastructure\Symfony\Service\TokenService;
use App\Backoffice\User\Application\UseCase\GetUserById\GetUserByIdQuery;
use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Query\QueryBus;

final class LoginCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly UserCredentialRepository $userCredentialRepository,
        private readonly PasswordHasher $passwordHasher,
        private readonly TokenService $tokenService,
    ) {
    }

    public function __invoke(LoginCommand $command): AuthTokenDTO
    {
        try {
            $userCredential = $this->userCredentialRepository->getByUsername(Username::fromString($command->username));
        } catch (\Exception) {
            throw new InvalidCredentials();
        }

        if (!$this->passwordHasher->verify($userCredential->hashedPassword(), Password::fromString($command->password))) {
            throw new InvalidCredentials();
        }

        $userDTO = $this->queryBus
            ->ask(
                new GetUserByIdQuery(
                    userId: (string) $userCredential->userId(),
                )
            );

        return $this->tokenService->encode(AuthUserDTO::createFromUserDTO($userDTO));
    }
}
