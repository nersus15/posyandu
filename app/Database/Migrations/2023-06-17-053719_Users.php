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
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '18',
                'null' => false,
                'default' => 'su'
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => null,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => 'default.jpg',
                'null' => true
            ],
            'faskes' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'default' => null,
                'null' => true,
            ],
            'wilayah_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => null,
                'null' => true,
            ]
        ]);
        $this->forge->addKey('username', true, true);
        $this->forge->addKey('hp', true, true);
        $this->forge->addKey('email', true, true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
