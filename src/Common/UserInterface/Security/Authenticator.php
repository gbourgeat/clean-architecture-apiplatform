<?php

declare(strict_types=1);

namespace App\Common\UserInterface\Security;

use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Application\UseCase\GetFromToken\GetFromTokenQuery;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class Authenticator extends AbstractAuthenticator
{
    public const HEADER_AUTHORIZATION = 'AUTHORIZATION';

    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::HEADER_AUTHORIZATION);
    }

    public function authenticate(Request $request): Passport
    {
        $explodeBearerToken = explode(' ', $request->headers->get(self::HEADER_AUTHORIZATION));

        $authUser = $this->authUserFromAuthToken($explodeBearerToken[1]);

        return new SelfValidatingPassport(new UserBadge($authUser->userId, static function () use ($authUser) {
            return $authUser;
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function authUserFromAuthToken(string $authToken): AuthUserDTO
    {
        return $this->queryBus
            ->ask(
                new GetFromTokenQuery(
                    token: $authToken,
                )
            );
    }
}
