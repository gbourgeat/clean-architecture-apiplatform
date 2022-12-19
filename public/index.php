<?php

use App\Common\Infrastructure\Symfony\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $_SERVER['HTTP_X_FORWARDED_PORT'] = '443';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';

    return new Kernel((string) $context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
