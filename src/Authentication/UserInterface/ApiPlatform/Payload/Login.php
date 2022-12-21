<?php

declare(strict_types=1);

namespace App\Authentication\UserInterface\ApiPlatform\Payload;

use Symfony\Component\Validator\Constraints as Assert;

final class Login
{
    public function __construct(
        #[Assert\NotNull(groups: ['login'])]
        public readonly string $email,

        #[Assert\NotNull(groups: ['login'])]
        public readonly string $password,
    ) {
    }
}
