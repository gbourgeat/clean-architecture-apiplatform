<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

enum CursorDirection: string
{
    case BEFORE = '<';
    case AFTER = '>';
}
