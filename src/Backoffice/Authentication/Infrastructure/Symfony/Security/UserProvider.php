<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Infrastructure\Symfony\Security;

use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Common\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return Auth::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->getByEmail(Email::fromString($identifier));

        return Auth::fromAuthUser($user->authUser());
    }
}
