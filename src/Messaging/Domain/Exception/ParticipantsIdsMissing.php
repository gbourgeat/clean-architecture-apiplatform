<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

final class ParticipantsIdsMissing extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Valid participants list must be given for create conversation.');
    }
}
