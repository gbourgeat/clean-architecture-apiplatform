<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Infrastructure\Doctrine\Repository;

use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Backoffice\Workspace\Domain\Repository\WorkspaceRepository;
use App\Common\Infrastructure\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineWorkspaceRepository extends DoctrineRepository implements WorkspaceRepository
{
    private const ENTITY_CLASS = Workspace::class;
    private const ALIAS = 'workspace';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Workspace $workspace): void
    {
        $this->em->persist($workspace);
        $this->em->flush();
    }
}
