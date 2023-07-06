<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anak extends Migration
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
            'kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'default' => 'L'
            ],
            'bbl' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'dalam gr',
            ],
            'ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
            ],
            'ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
                'null' => true
            ],
            'akb' => [
                'type' => 'INT',
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('anak');
    }

    public function down()
    {
        $this->forge->dropTable('anak');
    }
}
