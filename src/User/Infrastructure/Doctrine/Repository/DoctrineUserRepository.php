<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\Common\Domain\ValueObject\Email;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFound;
use App\User\Domain\Exception\UserNotFoundWithId;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @template-extends ServiceEntityRepository<User>
 */
final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
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

    public function search(int $pageNumber, int $itemsPerPage): array
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        $queryBuilder
            ->setFirstResult(($pageNumber - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage)
            ->orderBy(new OrderBy(self::ALIAS . '.createdAt'));

        return $queryBuilder->getQuery()->getResult();
    }
}
