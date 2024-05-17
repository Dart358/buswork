<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'number'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'capacity'     => ['type' => 'INT'],
            'contractorId' => ['type' => 'VARCHAR', 'constraint' => 255],
            'conductorId'  => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('number', true);
        $this->forge->createTable('bus');
    }

    public function down()
    {
        $this->forge->dropTable('bus');
    }
}
