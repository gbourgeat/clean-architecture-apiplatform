<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Common\UserInterface\ApiPlatform\OpenApi\CursorFilter;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\UserInterface\ApiPlatform\Processor\CreateConversationProcessor;
use App\Messaging\UserInterface\ApiPlatform\Provider\ConversationProvider;
use App\Messaging\UserInterface\ApiPlatform\Provider\ConversationsProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Conversation',
    operations: [
        new GetCollection(
            openapiContext: ['summary' => 'List conversations.'],
            paginationItemsPerPage: 5,
            paginationPartial: true,
            paginationFetchJoinCollection: false,
            paginationViaCursor: [
                [
                    'field' => 'createdAt',
                    'direction' => 'DESC',
                ],
            ],
            normalizationContext: ['groups' => 'read'],
            filters: [CursorFilter::class],
            provider: ConversationsProvider::class,
        ),
        new Get(
            openapiContext: ['summary' => 'Get conversation details.'],
            normalizationContext: ['groups' => 'read'],
            provider: ConversationProvider::class,
        ),
        new Post(
            openapiContext: ['summary' => 'Create new conversation.'],
            denormalizationContext: ['groups' => 'create'],
            validationContext: ['groups' => ['create']],
            processor: CreateConversationProcessor::class,
        ),
    ],
)]
final class ConversationResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        #[Groups('read')]
        public ?string $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Count(min: 2, groups: ['create'])]
        #[Groups(['create', 'read'])]
        public ?array $participants = [],

        #[Groups(['read'])]
        public ?string $createdAt = null,
    ) {
    }

    public static function fromEntity(Conversation $conversation): ConversationResource
    {
        return new self(
            (string) $conversation->id(),
            $conversation->participants(),
            $conversation->createdAt()->toISOString(),
        );
    }
}
