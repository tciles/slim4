<?php

use App\Factory\LoggerFactory;
use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $loggerFactory = $app->getContainer()->get(LoggerFactory::class);
    $logger = $loggerFactory->addFileHandler('error.log')->createInstance('error');

    // $errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);
    $app->addErrorMiddleware(true, true, true, $logger);
};
