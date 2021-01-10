<?php


namespace App\Controller;


use App\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractBaseController
{
    public function listAllUsers(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $service = $this->get(UserService::class);

        $response = $this->render($response, 'user/list_all.twig', [
            'users' => $service->getAll()
        ]);

        return $response;
    }
}
