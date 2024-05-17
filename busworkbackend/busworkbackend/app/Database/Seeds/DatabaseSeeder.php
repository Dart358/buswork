<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('BusSeeder');
        $this->call('ScheduleSeeder');
        $this->call('TicketSeeder');
        $this->call('OrderSeeder');
        $this->call('ConductorSeeder');
        $this->call('ContractorSeeder');
    }
}
