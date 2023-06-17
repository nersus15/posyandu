<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'profile' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
                'null' => true,
                'default' => null
            ]
        ]);
        $this->forge->addKey('username', true, true);
        $this->forge->addKey('email', false, true);
        $this->forge->addForeignKey('profile', 'profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
