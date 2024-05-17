<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'schedule-1',
                'busNumber' => 'BUS-001',
                'checkpoints' => json_encode(['Checkpoint 1', 'Checkpoint 2']),
                'from' => 'City A',
                'to' => 'City B',
                'departureTime' => '08:00 AM',
                'days' => json_encode(['Monday', 'Wednesday', 'Friday']),
                'ticketPrice' => 100
            ],
            [
                'id' => 'schedule-2',
                'busNumber' => 'BUS-002',
                'checkpoints' => json_encode(['Checkpoint 3', 'Checkpoint 4']),
                'from' => 'City B',
                'to' => 'City C',
                'departureTime' => '02:00 PM',
                'days' => json_encode(['Tuesday', 'Thursday']),
                'ticketPrice' => 120
            ]
        ];

        // Using Query Builder
        $this->db->table('schedule')->insertBatch($data);
    }
}
