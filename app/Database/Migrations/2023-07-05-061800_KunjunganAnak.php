<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KunjunganAnak extends Migration
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
            'nama_pemeriksa' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'dibuat DATETIME NOT NULL DEFAULT current_timestamp',
            'anak' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'bulan' => [
                'type' => 'DATE',
            ],
            'berat' => [
                'type' => 'INT',
                'comment' => 'dalam gr'
            ],
            'tinggi' => [
                'type' => 'INT',
                'comment' => 'dalam cm'
            ],
            
        ]);
        $this->forge->addForeignKey('anak', 'anak', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kunjungan_anak');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan_anak');
    }
}
