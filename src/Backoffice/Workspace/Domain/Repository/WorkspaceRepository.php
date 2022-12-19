<?php

declare(strict_types=1);

namespace App\Backoffice\Workspace\Domain\Repository;

use App\Backoffice\Workspace\Domain\Entity\Workspace;
use App\Common\Domain\Repository\Repository;

interface WorkspaceRepository extends Repository
{
    public function save(Workspace $workspace): void;
}
