<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Messaging\Application\UseCase\GetConversation\GetConversationQuery;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\UserInterface\ApiPlatform\Resource\ConversationResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ConversationProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            /** @var Conversation|null $conversation */
            $conversation = $this->queryBus->ask(new GetConversationQuery(ConversationId::fromString((string) $uriVariables['id'])));
        } catch (\InvalidArgumentException $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

        return null !== $conversation ? ConversationResource::fromEntity($conversation) : null;
    }
}
