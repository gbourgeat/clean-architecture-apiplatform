<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Backoffice\Authentication\Application\UseCase\Login\LoginCommand;
use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Payload\LoginPayload;
use App\Common\Application\Command\CommandBus;
use Webmozart\Assert\Assert;

final class LoginProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, LoginPayload::class);
        /** @var LoginPayload $loginPayload */
        $loginPayload = $data;

        $this->commandBus
            ->dispatch(
                new LoginCommand(
                    AuthUsername::fromString($loginPayload->email),
                    AuthPassword::fromString($loginPayload->password),
                )
            );
    }
}
