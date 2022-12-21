<?php

declare(strict_types=1);

namespace App\Authentication\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\UseCase\Login\LoginCommand;
use App\Authentication\UserInterface\ApiPlatform\Output\JWT;
use App\Authentication\UserInterface\ApiPlatform\Payload\Login;
use App\Common\Application\Command\CommandBus;
use Webmozart\Assert\Assert;

final class LoginProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JWT
    {
        Assert::isInstanceOf($data, Login::class);

        /** @var Login $loginPayload */
        $loginPayload = $data;

        $authToken = $this->login($loginPayload);

        return JWT::fromAuthTokenDTO($authToken);
    }

    private function login(Login $loginPayload): AuthTokenDTO
    {
        return $this->commandBus
            ->dispatch(
                new LoginCommand(
                    $loginPayload->email,
                    $loginPayload->password,
                )
            );
    }
}
