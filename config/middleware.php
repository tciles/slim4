<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use App\Factory\LoggerFactory;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Catch exceptions and errors
    //$app->add(ErrorMiddleware::class);

    $loggerFactory = $app->getContainer()->get(LoggerFactory::class);
    $logger = $loggerFactory->addFileHandler('error.log')->createInstance('error');

    $errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);
};
