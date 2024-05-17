<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'uuid-1',
                'email' => 'user1@example.com',
                'name' => 'User One',
                'picture' => 'user1.jpg',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'uuid-2',
                'email' => 'user2@example.com',
                'name' => 'User Two',
                'picture' => 'user2.jpg',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
