<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Infrastructure\Symfony\Service;

use App\Backoffice\Authentication\Domain\Exception\InvalidCredentials;
use App\Backoffice\Authentication\Domain\Service\Authenticator;
use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Backoffice\Users\Domain\Exception\UserNotFoundWithEmail;
use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Common\Domain\ValueObject\Email;

class AuthenticatorService implements Authenticator
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        try {
            $user = $this->userRepository->getByEmail(Email::fromString((string) $username));
        } catch (UserNotFoundWithEmail) {
            throw new InvalidCredentials();
        }
    }
}
