<?php

declare(strict_types=1);

namespace App\Messaging\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Application\Command\CommandBus;
use App\Messaging\Application\UseCase\SendMessage\SendMessageCommand;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\Domain\ValueObject\MessageContent;
use App\Messaging\UserInterface\ApiPlatform\Resource\ConversationResource;
use App\Messaging\UserInterface\ApiPlatform\Resource\MessageResource;
use Symfony\Component\Security\Core\Security;
use Webmozart\Assert\Assert;

final class SendMessageProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly Security $security,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, MessageResource::class);
        $messageResource = $data;

        /** @var ConversationResource $conversationResource */
        $conversationResource = $context['previous_data'];

        $this->commandBus
            ->dispatch(
                new SendMessageCommand(
                    UserId::fromString((string) $this->security->getUser()?->getUserIdentifier()),
                    ConversationId::fromString((string) $conversationResource->id),
                    MessageContent::fromString((string) $messageResource->content),
                )
            );
    }
}
