<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Infrastructure\Doctrine\Repository;

use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\Exception\UserNotFoundWithEmail;
use App\Backoffice\Users\Domain\Repository\UserRepository;
use App\Backoffice\Users\Domain\ValueObject\ExternalId;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
        $this->getEntityManager()->flush();
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

    /**
     * @throws NonUniqueResultException|UserNotFoundException
     */
    public function getByExternalId(ExternalId $externalId): User
    {
        $expressionBuilder = $this->getEntityManager()->getExpressionBuilder();
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        $queryBuilder
            ->where($expressionBuilder->eq(self::ALIAS.'.externalId', ':externalId'))
            ->setParameter('externalId', $externalId);

        /** @var ?User $user */
        $user = $queryBuilder->getQuery()->getOneOrNullResult();
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException|UserNotFoundException
     */
    public function getByEmail(Email $email): User
    {
        $expressionBuilder = $this->getEntityManager()->getExpressionBuilder();
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        $queryBuilder
            ->where($expressionBuilder->eq(self::ALIAS.'.email', ':email'))
            ->setParameter('email', $email);

        /** @var ?User $user */
        $user = $queryBuilder->getQuery()->getOneOrNullResult();

        if (null === $user) {
            throw new UserNotFoundWithEmail($email);
        }

        return $user;
    }
}
