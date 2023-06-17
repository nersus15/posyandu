<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
                'null' => false,
            ],
            'nama_lengkap' => [
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
            'faskes' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true, true);
        $this->forge->addKey('hp', false, true);
        $this->forge->createTable('profile');
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
