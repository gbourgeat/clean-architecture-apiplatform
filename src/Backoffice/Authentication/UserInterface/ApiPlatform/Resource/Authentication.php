<?php

declare(strict_types=1);

namespace App\Backoffice\Authentication\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Payload\LoginPayload;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Payload\SignupPayload;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Processor\LoginProcessor;
use App\Backoffice\Authentication\UserInterface\ApiPlatform\Processor\SignupProcessor;

#[ApiResource(
    shortName: 'Authentication',
    operations: [
        new Post(
            '/login',
            openapiContext: ['summary' => 'Login'],
            denormalizationContext: ['groups' => ['login']],
            validationContext: ['groups' => ['login']],
            input: LoginPayload::class,
            processor: LoginProcessor::class,
        ),
        new Post(
            '/signup',
            openapiContext: ['summary' => 'Signup'],
            denormalizationContext: ['groups' => ['signup']],
            validationContext: ['groups' => ['create']],
            input: SignupPayload::class,
            processor: SignupProcessor::class,
        ),
    ],
)]
final class Authentication
{
}
