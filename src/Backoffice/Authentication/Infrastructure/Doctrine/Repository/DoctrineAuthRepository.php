<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Infrastructure\Doctrine\Repository;

use App\Backoffice\Authentication\Domain\Entity\SecurityUser;
use App\Backoffice\Authentication\Domain\Repository\AuthRepository;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Backoffice\Users\Domain\Exception\UserNotFoundWithEmail;
use App\Backoffice\Users\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use App\Common\Domain\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

final class DoctrineAuthRepository implements AuthRepository
{
    public function __construct(
        private readonly DoctrineUserRepository $userRepository,
    ) {
    }

    public function getByUsername(AuthUsername $username): SecurityUser
    {
        if ($username->isEmail()) {
            throw new \InvalidArgumentException('Actually only email are accept as username.');
        }

        try {
            $user = $this->userRepository->getByEmail(Email::fromString($username->value()));
        } catch (NonUniqueResultException|UserNotFoundWithEmail) {
            throw new \LogicException('User not found with this email.');
        }

        return $user->authUser();
    }
}
