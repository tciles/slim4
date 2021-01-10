<?php

namespace App\Controller;

use App\Responder\Responder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractBaseController.
 */
class AbstractBaseController
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * AbstractBaseController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function get(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * @param ResponseInterface $response
     * @param array $data
     * @param int $options
     *
     * @return ResponseInterface
     */
    protected function json(ResponseInterface $response, array $data = [], $options = 0): ResponseInterface
    {
        $responder = $this->get(Responder::class);

        if (!isset($data['data'])) {
            $data = ['data' => $data];
        }

        return $responder->json($response, $data, $options);
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $viewData
     *
     * @return ResponseInterface
     */
    protected function render(ResponseInterface $response, string $template, array $viewData = []): ResponseInterface
    {
        $responder = $this->get(Responder::class);

        return $responder->render($response, $template, $viewData);
    }
}
