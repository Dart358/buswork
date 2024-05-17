<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConductorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'name'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('conductor');
    }

    public function down()
    {
        $this->forge->dropTable('conductor');
    }
}
