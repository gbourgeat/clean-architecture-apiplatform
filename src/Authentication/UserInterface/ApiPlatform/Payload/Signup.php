<?php

declare(strict_types=1);

namespace App\Authentication\UserInterface\ApiPlatform\Payload;

use Symfony\Component\Validator\Constraints as Assert;

final class Signup
{
    public function __construct(
        #[Assert\NotNull(groups: ['signup'])]
        public readonly string $firstName,

        #[Assert\NotNull(groups: ['signup'])]
        public readonly string $lastName,

        #[Assert\NotNull(groups: ['signup'])]
        public readonly string $email,

        #[Assert\NotNull(groups: ['signup'])]
        public readonly string $password,

        #[Assert\NotNull(groups: ['signup'])]
        public readonly string $passwordConfirm,
    ) {
    }
}
