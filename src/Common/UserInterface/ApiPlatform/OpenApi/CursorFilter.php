<?php

declare(strict_types=1);

namespace App\Common\UserInterface\ApiPlatform\OpenApi;

use ApiPlatform\Api\FilterInterface;
use Symfony\Component\PropertyInfo\Type;

final class CursorFilter implements FilterInterface
{
    public function getDescription(string $resourceClass): array
    {
        return [
            'cursor' => [
                'property' => 'cursor',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
        ];
    }
}
