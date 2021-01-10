<?php

use Phinx\Seed\AbstractSeed;

class UserDataSeed extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'jDoe@gmail.com',
                'username' => 'jDoe',
                'password' => '123456',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'email' => 'jaDoe@gmail.com',
                'username' => 'jaDoe',
                'password' => '123456',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $table = $this->table('user');
        $table->insert($data)->saveData();
    }
}
