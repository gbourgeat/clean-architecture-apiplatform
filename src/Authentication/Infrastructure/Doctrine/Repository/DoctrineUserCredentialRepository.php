<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Doctrine\Repository;

use App\Authentication\Domain\Entity\UserCredential;
use App\Authentication\Domain\Exception\CredentialNotFoundForUsername;
use App\Authentication\Domain\Repository\UserCredentialRepository;
use App\Authentication\Domain\ValueObject\Username;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<UserCredential>
 */
final class DoctrineUserCredentialRepository extends ServiceEntityRepository implements UserCredentialRepository
{
    private const ALIAS = 'user_credential';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCredential::class);
    }

    public function getByUsername(Username $username): UserCredential
    {
        $expressionBuilder = $this->getEntityManager()->getExpressionBuilder();
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        $queryBuilder
            ->where($expressionBuilder->eq(self::ALIAS.'.username', ':username'))
            ->setParameter('username', $username);

        /** @var ?UserCredential $userCredential */
        $userCredential = $queryBuilder->getQuery()->getOneOrNullResult();
        if (null === $userCredential) {
            throw new CredentialNotFoundForUsername($username);
        }

        return $userCredential;
    }

    public function add(UserCredential $userCredential): void
    {
        $this->getEntityManager()->persist($userCredential);
    }
}
