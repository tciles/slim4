<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Responder\Responder;

class AbstractBaseController {
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    protected function get($name) 
    {
        return $this->container->get($name);
    }

    protected function json(ResponseInterface $response, $data, $options = 0) {
        $responder = $this->get(Responder::class);

        return $responder->json($response, ['data' => $data], $options);
    }

    protected function render(ResponseInterface $response, $template, array $viewData = [])
    {
        $responder = $this->get(Responder::class);

        return $responder->render($response, $template, $viewData);
    }
}

