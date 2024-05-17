<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'orderId'        => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'passengerEmail' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ticket');
    }

    public function down()
    {
        $this->forge->dropTable('ticket');
    }
}
