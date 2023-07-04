<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KunjunganLansia extends Migration
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
            'lansia' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'bulan' => [
                'type' => 'DATE',
            ],
            'berat' => [
                'type' => 'INT'
            ]
        ]);
        $this->forge->addForeignKey('lansia', 'lansia', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kunjungan_lansia');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan_lansia');
    }
}
