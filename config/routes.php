<?php

use App\Controller\HomeController;
use App\Controller\UserController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':home');
    $app->get('/version', HomeController::class . ':version');

    $app->get('/users', UserController::class . ':listAllUsers');
};
