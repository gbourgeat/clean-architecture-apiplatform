<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\Domain\Entity;

use App\Backoffice\Authentication\Domain\Exception\NewPasswordShouldBeDifferentOfCurrentPassword;
use App\Backoffice\Authentication\Domain\ValueObject\AuthUsername;
use App\Backoffice\Authentication\Domain\ValueObject\AuthPassword;

final class SecurityUser
{
    private function __construct(
        private readonly AuthUsername $username,
        private AuthPassword $password,
    ) {
    }

    public static function create(
        AuthUsername $username,
        AuthPassword $password,
    ): SecurityUser {
        return new self($username, $password);
    }

    /*
     * ===============================
     * == Getters
     * ===============================
     */

    public function username(): AuthUsername
    {
        return $this->username;
    }

    public function password(): AuthPassword
    {
        return $this->password;
    }

    public function roles(): array
    {
        return ['ROLE_USER'];
    }

    /*
     * ===============================
     * == Actions
     * ===============================
     */

    /**
     * @throws NewPasswordShouldBeDifferentOfCurrentPassword
     */
    public function changePassword(AuthPassword $newPassword): void
    {
        if ($this->password->isEqual($newPassword)) {
            throw new NewPasswordShouldBeDifferentOfCurrentPassword();
        }

        $this->password = $newPassword;
    }
}
