<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tokens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '46'
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'expired DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'used DATETIME NULL DEFAULT NULL'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tokens', true);
    }

    public function down()
    {
        $this->forge->dropTable('tokens', true);
    }
}
