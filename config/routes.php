<?php

use \App\Controller\HomeController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':home');
    $app->get('/version', HomeController::class . ':version');
};
