<?php

declare(strict_types=1);

namespace App\Backoffice\User\Infrastructure\Doctrine\Repository;

use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\Exception\UserNotFound;
use App\Backoffice\User\Domain\Exception\UserNotFoundWithId;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Common\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    private const ALIAS = 'user';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    /**
     * @throws UserNotFound
     */
    public function get(UserId $id): User
    {
        /** @var ?User $user */
        $user = $this->find($id);
        if (null === $user) {
            throw new UserNotFoundWithId($id);
        }

        return $user;
    }

    public function emailExist(Email $email): bool
    {
        $userWithEmail = $this->findOneBy(['email' => $email]);

        return (null !== $userWithEmail);
    }
}
