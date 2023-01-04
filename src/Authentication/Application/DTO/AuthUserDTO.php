<?php

declare(strict_types=1);

namespace App\Authentication\Application\DTO;

use App\User\Application\DTO\UserDTO;

final class AuthUserDTO
{
    private function __construct(
        public readonly string $userId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
    ) {
    }

    public static function createFromUserDTO(UserDTO $userDTO): AuthUserDTO
    {
        return new self(
            userId: $userDTO->id,
            firstName: $userDTO->firstName,
            lastName: $userDTO->lastName,
            email: $userDTO->email,
        );
    }

    public static function createFromJWTPayload(array $jwtPayload): AuthUserDTO
    {
        return new self(
            userId: $jwtPayload['userId'],
            firstName: $jwtPayload['firstName'],
            lastName: $jwtPayload['lastName'],
            email: $jwtPayload['email'],
        );
    }
}
