<?php

namespace App\Repository;

use PDO;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * UserRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $sql = 'SELECT * FROM user';
        $q = $this->pdo->query($sql);
        $result = $q->fetchAll();

        if (empty($result)) {
            $result = [];
        }

        return $result;
    }
}
