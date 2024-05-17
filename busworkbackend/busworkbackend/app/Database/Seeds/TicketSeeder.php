<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'ticket-1',
                'orderId' => 'order-1',
                'passengerEmail' => 'passenger1@example.com'
            ],
            [
                'id' => 'ticket-2',
                'orderId' => 'order-2',
                'passengerEmail' => 'passenger2@example.com'
            ]
        ];

        // Using Query Builder
        $this->db->table('ticket')->insertBatch($data);
    }
}
