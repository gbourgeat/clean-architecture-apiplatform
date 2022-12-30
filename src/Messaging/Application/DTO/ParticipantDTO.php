<?php

declare(strict_types=1);

namespace App\Messaging\Application\DTO;

use App\Messaging\Domain\Entity\Participant;

final class ParticipantDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $userId,
    ) {
    }

    public static function fromEntity(
        Participant $participant,
    ): ParticipantDTO {
        return new self(
            id: (string) $participant->id(),
            name: (string) $participant->name(),
            userId: (string) $participant->userId(),
        );
    }
}
