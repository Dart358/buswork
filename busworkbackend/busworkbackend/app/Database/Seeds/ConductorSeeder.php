<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConductorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'conductor-1',
                'name' => 'Conductor One',
                'phone' => '1234567890'
            ],
            [
                'id' => 'conductor-2',
                'name' => 'Conductor Two',
                'phone' => '0987654321'
            ]
        ];

        // Using Query Builder
        $this->db->table('conductor')->insertBatch($data);
    }
}
