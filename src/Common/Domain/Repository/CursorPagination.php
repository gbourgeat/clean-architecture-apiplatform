<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

interface CursorPagination extends \IteratorAggregate
{
    public function nextCursor(): ?Cursor;
    public function prevCursor(): ?Cursor;
}
