<?php

declare(strict_types=1);

namespace App\Tests\Authentication\Application\UseCase;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\UseCase\Signup\SignupCommand;
use App\Authentication\Domain\Repository\UserCredentialRepository;
use App\Common\Application\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SignupTest extends KernelTestCase
{
    private CommandBus $commandBus;

    private UserCredentialRepository $userCredentialRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = self::getContainer()->get(CommandBus::class);
        $this->userCredentialRepository = self::getContainer()->get(UserCredentialRepository::class);
    }

    public function testSignup(): void
    {
        $beforeCountUsersCredentials = $this->userCredentialRepository->count([]);

        $signupCommand = new SignupCommand(
            firstName: 'Firstname',
            lastName: 'Lastname',
            email: 'test@test.test',
            password: 'MyP455w0R2',
            passwordConfirm: 'MyP455w0R2',
        );

        $authTokenDTO = $this->handle($signupCommand);

        $this->assertInstanceOf(AuthTokenDTO::class, $authTokenDTO);
        $this->assertObjectHasAttribute('token', $authTokenDTO);

        $token = $authTokenDTO->token;
        $this->assertNotEmpty($token);
        $this->assertIsString($token);

        $afterCountUsersCredentials = $this->userCredentialRepository->count([]);
        $this->assertEquals($beforeCountUsersCredentials + 1, $afterCountUsersCredentials);
    }

    private function handle(SignupCommand $signupCommand): mixed
    {
        return $this->commandBus->dispatch($signupCommand);
    }
}
