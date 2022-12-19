<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Messaging\Application\UseCase\CreateConversation\CreateConversationCommand;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\UserInterface\ApiPlatform\Resource\ConversationResource;
use Webmozart\Assert\Assert;

final class CreateConversationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ConversationResource
    {
        Assert::isInstanceOf($data, ConversationResource::class);
        /** @var ConversationResource $conversationResource */
        $conversationResource = $data;

        Assert::isArray($conversationResource->participants);

        /** @var Conversation $conversation */
        $conversation = $this->commandBus->dispatch(new CreateConversationCommand($conversationResource->participants));

        return ConversationResource::fromEntity($conversation);
    }
}
