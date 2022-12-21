<?php

declare(strict_types=1);

namespace App\Messaging\Domain\ValueObject;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Common\Domain\ValueObject\StringValue;

final class ParticipantName extends StringValue
{
    public static function fromUserDTO(UserDTO $userDTO): ParticipantName
    {
        return self::fromString($userDTO->firstName . ' ' . $userDTO->lastName);
    }
}
