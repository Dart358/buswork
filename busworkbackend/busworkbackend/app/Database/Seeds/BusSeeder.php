<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'number' => 'BUS-001',
                'capacity' => 50,
                'contractorId' => 'contractor-1',
                'conductorId' => 'conductor-1'
            ],
            [
                'number' => 'BUS-002',
                'capacity' => 45,
                'contractorId' => 'contractor-2',
                'conductorId' => 'conductor-2'
            ]
        ];

        // Using Query Builder
        $this->db->table('bus')->insertBatch($data);
    }
}
