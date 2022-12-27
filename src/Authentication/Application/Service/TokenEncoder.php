<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;

interface TokenEncoder
{
    public function encode(array $payload): string;
}
