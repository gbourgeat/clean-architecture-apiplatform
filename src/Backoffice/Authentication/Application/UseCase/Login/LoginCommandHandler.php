<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Application\UseCase\Login;

use App\Backoffice\Authentication\Domain\Service\Authenticator;
use App\Common\Application\Command\CommandHandler;

final class LoginCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly Authenticator $authenticator,
    ) {
    }

    public function __invoke(LoginCommand $command): void
    {
        $this->authenticator->authenticate($command->username, $command->password);
    }
}
