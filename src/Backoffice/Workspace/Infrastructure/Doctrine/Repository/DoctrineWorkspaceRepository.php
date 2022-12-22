<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Infrastructure\Doctrine\Repository;

use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Backoffice\Workspace\Domain\Repository\WorkspaceRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineWorkspaceRepository extends ServiceEntityRepository implements WorkspaceRepository
{
    private const ALIAS = 'workspace';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workspace::class);
    }

    public function add(Workspace $workspace): void
    {
        $this->getEntityManager()->persist($workspace);
    }
}
