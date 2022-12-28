<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\GetMessages;

use App\Common\Application\Query\QueryHandler;

final class GetMessagesQueryHandler implements QueryHandler
{
    public function __invoke(GetMessagesQuery $query): array
    {
        return [];
    }
}
