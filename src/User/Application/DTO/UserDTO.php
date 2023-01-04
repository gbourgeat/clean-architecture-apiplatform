<?php

declare(strict_types=1);

namespace App\User\Application\DTO;

use App\User\Domain\Entity\User;

final class UserDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: (string) $user->id(),
            firstName: (string) $user->firstName(),
            lastName: (string) $user->lastName(),
            email: (string) $user->email(),
        );
    }
}
