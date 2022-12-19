<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\UserInterface\ApiPlatform\Payload;

use Symfony\Component\Validator\Constraints as Assert;

final class LoginPayload
{
    public function __construct(
        #[Assert\NotNull(groups: ['login'])]
        public readonly string $email,

        #[Assert\NotNull(groups: ['login'])]
        public readonly string $password,
    ) {
    }
}
