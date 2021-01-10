<?php

namespace App\Service;

use App\Repository\UserRepository;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
