<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\UseCase\CreateUser;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): UserDTO
    {
        $user = User::create(
            firstName: FirstName::fromString($command->firstName),
            lastName: LastName::fromString($command->lastName),
            email: Email::fromString($command->email),
        );

        $this->userRepository->add($user);

        return UserDTO::fromEntity($user);
    }
}
