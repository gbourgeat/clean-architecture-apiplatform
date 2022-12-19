<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use Doctrine\ORM\QueryBuilder;

interface Cursor extends \Stringable
{
    public function applyOnQueryBuilder(QueryBuilder $queryBuilder, bool $reverse): void;
    public function createNextFromValue(?string $value): ?self;
    public function createPrevFromValue(?string $value): ?self;
}
