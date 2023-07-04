<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lansia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'registrar' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'dibuat DATETIME NOT NULL DEFAULT current_timestamp',
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 46
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 22,
                'null' => true
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
                'default' => null
            ],
            'estimasi_ttl' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lansia');
    }

    public function down()
    {
        $this->forge->dropTable('lansia');
    }
}
