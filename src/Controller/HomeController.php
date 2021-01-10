<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \App\Service\VersionService;

class HomeController extends AbstractBaseController {
    public function home(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $versionService = $this->get(VersionService::class);

        $viewData = [
            'appName' => 'Slim Application',
            'version' => $versionService->getVersion()
        ];

        return $this->render($response, 'home/home.twig', $viewData);
    }

    public function version(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $versionService = $this->get(VersionService::class);

        return $this->json($response, [
            'version' => $versionService->getVersion()
        ]);
    }
}

