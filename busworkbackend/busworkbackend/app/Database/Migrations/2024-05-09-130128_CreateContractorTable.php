<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContractorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'name'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'   => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'phone'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contractor');
    }

    public function down()
    {
        $this->forge->dropTable('contractor');
    }
}
