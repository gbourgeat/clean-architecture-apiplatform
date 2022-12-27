<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;

interface TokenDecoder
{
    public function decode(string $token): array;
}
