<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Backoffice\Authentication\Application\UseCase\Signup\SignupCommand;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Payload\SignupPayload;
use App\Common\Application\Command\CommandBus;
use Webmozart\Assert\Assert;

final class SignupProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, SignupPayload::class);
        /** @var SignupPayload $signupPayload */
        $signupPayload = $data;

        $this->commandBus
            ->dispatch(
                new SignupCommand(
                    $signupPayload->passwordConfirm
                )
            );
    }
}
