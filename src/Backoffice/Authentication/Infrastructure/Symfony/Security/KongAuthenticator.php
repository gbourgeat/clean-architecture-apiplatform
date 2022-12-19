<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Infrastructure\Symfony\Security;

use App\Backoffice\Authentication\Application\UseCase\Signup\SignupCommand;
use App\Backoffice\Users\Application\UseCase\GetUserWithEmail\GetUserWithEmailQuery;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use function App\Backoffice\Authentication\Presentation\Symfony\Security\strtr;

class KongAuthenticator extends AbstractAuthenticator
{
    public const HEADER_USERINFO = 'X-USERINFO';

    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::HEADER_USERINFO);
    }

    /**
     * @throws \JsonException
     */
    public function authenticate(Request $request): Passport
    {
        $userInfoHeader = $request->headers->get(self::HEADER_USERINFO);

        if (null === $userInfoHeader) {
            throw new CustomUserMessageAuthenticationException('No header given by Kong gateway');
        }

        $userInfoArray = json_decode(base64_decode($userInfoHeader, true), true, 512, JSON_THROW_ON_ERROR);

        $user = $this->queryBus->ask(new GetUserWithEmailQuery(Email::fromString($userInfoArray['email'])));

        if (null === $user) {
            $user = $this->commandBus
                ->dispatch(
                    new SignupCommand(
                        FirstName::fromString((string) $userInfoArray['given_name']),
                        LastName::fromString((string) $userInfoArray['family_name']),
                        Email::fromString((string) $userInfoArray['email']),
                    )
                );
        }

        return new SelfValidatingPassport(new UserBadge($userInfoHeader, static function () use ($user) {
            return $user;
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
}
