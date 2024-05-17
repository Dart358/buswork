<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'order-1',
                'userId' => 'uuid-1',
                'scheduleId' => 'schedule-1',
                'status' => 'pending',
                'amount' => 100,
                'attempts' => 0,
                'receipt' => 'receipt-1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'order-2',
                'userId' => 'uuid-2',
                'scheduleId' => 'schedule-2',
                'status' => 'confirmed',
                'amount' => 120,
                'attempts' => 1,
                'receipt' => 'receipt-2',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using Query Builder
        $this->db->table('order')->insertBatch($data);
    }
}
