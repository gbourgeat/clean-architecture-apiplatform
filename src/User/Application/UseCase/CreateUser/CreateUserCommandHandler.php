<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\CreateUser;

use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;
use App\User\Application\DTO\UserDTO;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\EmailAlreadyUsed;
use App\User\Domain\Repository\UserRepository;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws EmailAlreadyUsed|InvalidFormat
     */
    public function __invoke(CreateUserCommand $command): UserDTO
    {
        $email = Email::fromString($command->email);
        $this->ensureEmailNotExist($email);

        $user = User::create(
            firstName: FirstName::fromString($command->firstName),
            lastName: LastName::fromString($command->lastName),
            email: $email,
        );

        $this->userRepository->add($user);

        return UserDTO::fromEntity($user);
    }

    /**
     * @throws EmailAlreadyUsed
     */
    private function ensureEmailNotExist(Email $email): void
    {
        if ($this->userRepository->emailExist($email)) {
            throw new EmailAlreadyUsed($email);
        }
    }
}
