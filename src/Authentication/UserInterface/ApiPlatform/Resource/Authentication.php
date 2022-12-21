<?php

declare(strict_types=1);

namespace App\Authentication\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Authentication\UserInterface\ApiPlatform\Output\JWT;
use App\Authentication\UserInterface\ApiPlatform\Payload\Login;
use App\Authentication\UserInterface\ApiPlatform\Payload\Signup;
use App\Authentication\UserInterface\ApiPlatform\Processor\LoginProcessor;
use App\Authentication\UserInterface\ApiPlatform\Processor\SignupProcessor;

#[ApiResource(
    shortName: 'Authentication',
    operations: [
        new Post(
            '/login',
            openapiContext: ['summary' => 'Login'],
            validationContext: ['groups' => ['login']],
            input: Login::class,
            output: JWT::class,
            processor: LoginProcessor::class,
        ),
        new Post(
            '/signup',
            openapiContext: ['summary' => 'Signup'],
            validationContext: ['groups' => ['create', 'signup']],
            input: Signup::class,
            output: JWT::class,
            processor: SignupProcessor::class,
        ),
    ],
    routePrefix: '/auth',
)]
final class Authentication
{
}
