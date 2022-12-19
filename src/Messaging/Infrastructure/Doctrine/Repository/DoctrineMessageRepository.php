<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Repository;

use App\Messaging\Domain\Entity\Message;
use App\Messaging\Domain\Repository\MessageRepository;
use App\Messaging\Domain\ValueObject\ConversationId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineMessageRepository extends ServiceEntityRepository implements MessageRepository
{
    public const ALIAS = 'message';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function withConversationId(ConversationId $conversationId): Collection
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        return $queryBuilder
                ->where($queryBuilder->expr()->eq(self::ALIAS.'.conversation', ':conversationId'))
                ->setParameter('conversationId', (string) $conversationId)
                ->orderBy($this->query()->expr()->desc(self::ALIAS.'.sentAt'))
                ->getQuery()
                ->getResult();
    }
}
