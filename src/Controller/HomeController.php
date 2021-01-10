<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \App\Service\VersionService;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractBaseController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $versionService = $this->get(VersionService::class);

        $viewData = [
            'appName' => 'Slim Application',
            'version' => $versionService->getVersion()
        ];

        return $this->render($response, 'home/home.twig', $viewData);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function version(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $versionService = $this->get(VersionService::class);

        return $this->json($response, [
            'version' => $versionService->getVersion()
        ]);
    }
}

