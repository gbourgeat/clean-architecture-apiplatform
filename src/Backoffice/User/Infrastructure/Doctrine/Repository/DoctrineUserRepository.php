<?php

declare(strict_types=1);

namespace App\Backoffice\User\Infrastructure\Doctrine\Repository;

use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Backoffice\User\Domain\ValueObject\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

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
     * @throws UserNotFoundException
     */
    public function get(UserId $id): User
    {
        /** @var ?User $user */
        $user = $this->find($id);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
