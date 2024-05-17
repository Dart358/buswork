<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'picture'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'user'],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
