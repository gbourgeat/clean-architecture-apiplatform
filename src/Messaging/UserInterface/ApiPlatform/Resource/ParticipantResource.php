<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Messaging\Application\DTO\ParticipantDTO;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Participant',
    operations: [],
)]
final class ParticipantResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        #[Groups('read')]
        public ?string $id = null,

        #[Groups(['read'])]
        public ?string $name = '',

        #[Groups(['read'])]
        public ?string $userId = '',
    ) {
    }

    public static function fromParticipantDTO(ParticipantDTO $participantDTO): ParticipantResource
    {
        return new self(
            id: $participantDTO->id,
            name: $participantDTO->name,
            userId: $participantDTO->userId,
        );
    }
}
