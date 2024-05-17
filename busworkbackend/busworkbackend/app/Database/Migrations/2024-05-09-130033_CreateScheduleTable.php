<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScheduleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'busNumber'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'checkpoints'   => ['type' => 'TEXT'],
            'from'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'to'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'departureTime' => ['type' => 'VARCHAR', 'constraint' => 100],
            'days'          => ['type' => 'TEXT'],
            'ticketPrice'   => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('schedule');
    }

    public function down()
    {
        $this->forge->dropTable('schedule');
    }
}
