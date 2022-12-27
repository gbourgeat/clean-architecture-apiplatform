<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\GetAuthUserFromToken;

use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Infrastructure\Symfony\Service\TokenService;
use App\Common\Application\Query\QueryHandler;

final class GetAuthUserFromTokenQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TokenService $tokenService,
    ) {
    }

    public function __invoke(GetAuthUserFromTokenQuery $query): AuthUserDTO
    {
        return AuthUserDTO::createFromJWTPayload($this->tokenService->decode($query->token));
    }
}
