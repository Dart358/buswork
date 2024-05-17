<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'userId'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'scheduleId' => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pending'],
            'amount'     => ['type' => 'INT'],
            'attempts'   => ['type' => 'INT', 'default' => 0],
            'receipt'    => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order');
    }

    public function down()
    {
        $this->forge->dropTable('order');
    }
}
