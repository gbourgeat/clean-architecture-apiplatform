<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Authentication\Domain\ValueObject\Username;

final class CredentialNotFoundForUsername extends \DomainException
{
    public function __construct(Username $username)
    {
        parent::__construct(sprintf('Credential not found for username "%s"', (string) $username));
    }
}
