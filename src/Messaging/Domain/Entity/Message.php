<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Messaging\Domain\ValueObject\MessageContent;
use App\Messaging\Domain\ValueObject\MessageId;
use Carbon\Carbon;

class Message
{
    private MessageId $id;
    private Conversation $conversation;
    private MessageContent $content;
    private Carbon $sentAt;
    private Participant $sentBy;

    private function __construct(
        Conversation $conversation,
        MessageContent $content,
        Carbon $sentAt,
        Participant $sentBy,
    ) {
        $this->id = MessageId::generate();
        $this->conversation = $conversation;
        $this->content = $content;
        $this->sentAt = $sentAt;
        $this->sentBy = $sentBy;
    }

    public static function create(
        Conversation $conversation,
        MessageContent $content,
        Carbon $sentAt,
        Participant $sentBy,
    ): self {
        return new self(
            $conversation,
            $content,
            $sentAt,
            $sentBy,
        );
    }

    public function id(): MessageId
    {
        return $this->id;
    }

    public function conversation(): Conversation
    {
        return $this->conversation;
    }

    public function content(): MessageContent
    {
        return $this->content;
    }

    public function sentBy(): Participant
    {
        return $this->sentBy;
    }

    public function sentAt(): Carbon
    {
        return $this->sentAt;
    }
}
