<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Application\UseCase\Signup;

use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Common\Application\Command\CommandHandler;

final class SignupCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(SignupCommand $command): User
    {
        $user = User::create(
            $command->firstName,
            $command->lastName,
            $command->email,
            $command->roles,
            $command->externalId,
        );

        $this->userRepository->add($user);

        return $user;
    }
}
