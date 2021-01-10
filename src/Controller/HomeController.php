<?php

namespace App\Controller;

use App\Service\VersionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HomeController.
 */
class HomeController extends AbstractBaseController
{
    /**
     * HomePage.
     *
     * @param ServerRequestInterface $request  The request.
     * @param ResponseInterface      $response The response.
     * @param array                  $args     Arguments.
     *
     * @return ResponseInterface
     */
    public function home(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $versionService = $this->get(VersionService::class);

        $viewData = [
            'appName' => 'Slim Application',
            'version' => $versionService->getVersion(),
        ];

        $response = $this->render($response, 'home/home.twig', $viewData);

        return $response;
    }

    /**
     * Get the version.
     *
     * @param ServerRequestInterface $request  The request.
     * @param ResponseInterface      $response The response.
     * @param array                  $args     Arguments.
     *
     * @return ResponseInterface
     */
    public function version(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $versionService = $this->get(VersionService::class);

        $response = $this->json(
            $response,
            [
                'version' => $versionService->getVersion(),
            ]
        );

        return $response;
    }
}
