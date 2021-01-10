<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/var/cache');
}

$containerBuilder->addDefinitions(__DIR__ . '/container.php');

$container = $containerBuilder->build();

$app = $container->get(App::class);

(require_once __DIR__ . '/routes.php')($app);

(require_once __DIR__ . '/middleware.php')($app);

return $app;
