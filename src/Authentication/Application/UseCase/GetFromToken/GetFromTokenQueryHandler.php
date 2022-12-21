<?php

declare(strict_types=1);

namespace App\Authentication\Application\UseCase\GetFromToken;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Infrastructure\Symfony\Service\TokenService;
use App\Common\Application\Query\QueryHandler;

final class GetFromTokenQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TokenService $tokenService,
    ) {
    }

    public function __invoke(GetFromTokenQuery $query): AuthUserDTO
    {
        $jwtTokenDTO = AuthTokenDTO::fromString($query->token);

        return $this->tokenService->decode($jwtTokenDTO);
    }
}
