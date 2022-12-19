<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Domain\Exception;

use App\Common\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserNotFoundWithEmail extends UserNotFoundException
{
    public function __construct(Email $email)
    {
        parent::__construct(sprintf('User not found with email "%s".', (string) $email));
    }
}
