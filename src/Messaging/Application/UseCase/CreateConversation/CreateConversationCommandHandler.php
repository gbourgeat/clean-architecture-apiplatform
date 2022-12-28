<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\CreateConversation;

use App\Common\Application\Command\CommandHandler;
use App\Messaging\Application\DTO\ConversationDTO;
use App\Messaging\Application\Service\ConversationCreator;

final class CreateConversationCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ConversationCreator $conversationCreator,
    ) {
    }

    public function __invoke(CreateConversationCommand $command): ConversationDTO
    {
        $conversation = $this->conversationCreator->createConversation($command->members());

        return ConversationDTO::fromEntity($conversation);
    }
}
