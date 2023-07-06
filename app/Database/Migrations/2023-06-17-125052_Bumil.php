<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bumil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'nomor' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'rt' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'null' => false
            ],
            'nama_suami' => [
                'type' => 'VARCHAR', 
                'constraint' => '46',
                'null' => true,
                'default' => null
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'constraint' => null,
                'null' => true,
                'default' => null
            ],
            'ttl_estimasi' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'null' => false,
                'default' => '0'
            ],
            'domisili' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'null' => false
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '16', 
                'null' => false
            ],
            'pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
                'default' => '-'
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'null' => true,
                'default' => null
            ],
            'agama' => [
                'type' => 'ENUM', 
                'constraint' => ['-', 'islam', 'kristen katolik', 'hindu', 'kristen protestan', 'buda', 'konghucu'],
                'default' => '-'
            ],
            'kartu_kesehatan' => [
                'type' => 'VARCHAR',
                'constraint' => 46, 
                'null' => true
            ],
            'golongan_darah' => [
                'type' => 'ENUM',
                'constraint' => ['-', 'A', 'B', 'O', 'AB'],
                'default' => '-'
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true
            ],
            'registrar' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'dibuat DATETIME NOT NULL DEFAULT current_timestamp'
        ]);
        $this->forge->addKey('id', true, true);
        $this->forge->createTable('bumil');
    }

    public function down()
    {
        $this->forge->dropTable('bumil');
    }
}
