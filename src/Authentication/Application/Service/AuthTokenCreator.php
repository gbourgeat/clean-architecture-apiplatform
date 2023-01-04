<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\User\Application\DTO\UserDTO;

final class AuthTokenCreator
{
    public function __construct(
        private readonly TokenEncoder $tokenEncoder,
    ) {
    }

    public function createFromUserDTO(UserDTO $userDTO): AuthTokenDTO
    {
        $tokenPayload = [
            'userId' => $userDTO->id,
            'email' => $userDTO->email,
            'firstName' => $userDTO->firstName,
            'lastName' => $userDTO->lastName,
        ];

        return AuthTokenDTO::fromString($this->tokenEncoder->encode($tokenPayload));
    }
}
