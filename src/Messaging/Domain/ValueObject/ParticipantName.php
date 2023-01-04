<?php

declare(strict_types=1);

namespace App\Messaging\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;
use App\User\Application\DTO\UserDTO;

final class ParticipantName extends StringValue
{
    public static function fromUserDTO(UserDTO $userDTO): ParticipantName
    {
        return self::fromString($userDTO->firstName . ' ' . $userDTO->lastName);
    }
}
