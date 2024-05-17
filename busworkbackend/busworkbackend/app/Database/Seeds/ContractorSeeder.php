<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContractorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'contractor-1',
                'name' => 'Contractor One',
                'email' => 'contractor1@example.com',
                'phone' => '1234567890',
                'address' => 'Address 1'
            ],
            [
                'id' => 'contractor-2',
                'name' => 'Contractor Two',
                'email' => 'contractor2@example.com',
                'phone' => '0987654321',
                'address' => 'Address 2'
            ]
        ];

        // Using Query Builder
        $this->db->table('contractor')->insertBatch($data);
    }
}
