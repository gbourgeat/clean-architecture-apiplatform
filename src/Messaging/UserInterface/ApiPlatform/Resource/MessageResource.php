<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Messaging\Application\DTO\MessageDTO;
use App\Messaging\UserInterface\ApiPlatform\Processor\SendMessageProcessor;
use App\Messaging\UserInterface\ApiPlatform\Provider\ConversationProvider;
use App\Messaging\UserInterface\ApiPlatform\Provider\MessagesProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Message',
    operations: [
        new Post(
            '/conversations/{id}/messages',
            status: 201,
            openapiContext: ['summary' => 'Send message to conversation.'],
            denormalizationContext: ['groups' => 'create'],
            validationContext: ['groups' => ['create']],
            output: false,
            provider: ConversationProvider::class,
            processor: SendMessageProcessor::class,
        ),
        new GetCollection(
            '/conversations/{id}/messages',
            openapiContext: ['summary' => 'Get messages of conversation.'],
            normalizationContext: ['groups' => 'read'],
            provider: MessagesProvider::class,
        ),
    ],
)]
class MessageResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        #[Groups(['read'])]
        public ?string $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 256, groups: ['create'])]
        #[Groups(['create', 'read'])]
        public ?string $content = null,

        #[Groups(['read'])]
        public ?string $sentAt = null,

        #[Groups(['read'])]
        public ?ParticipantResource $sentBy = null,
    ) {
    }

    public static function fromMessageDTO(MessageDTO $messageDTO): MessageResource
    {
        return new MessageResource(
            id: $messageDTO->id,
            content: $messageDTO->content,
            sentAt: $messageDTO->sentAt,
            sentBy: ParticipantResource::fromParticipantDTO($messageDTO->sentBy),
        );
    }
}
