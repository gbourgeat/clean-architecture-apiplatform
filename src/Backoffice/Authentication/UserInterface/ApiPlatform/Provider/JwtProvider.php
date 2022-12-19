<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

final class JwtProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // TODO: Implement provide() method.
    }
}
