<?php

declare(strict_types=1);

namespace App\Common\UserInterface\ApiPlatform\Paginator;

use Symfony\Component\Serializer\Annotation\Groups;

class CursorResult
{
    public function __construct(
        #[Groups(['read'])]
        public array $data,
        #[Groups(['read'])]
        public string $prevCursor,
        #[Groups(['read'])]
        public string $nextCursor,
    ) {
    }
}
