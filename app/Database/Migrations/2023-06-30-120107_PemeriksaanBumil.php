<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PemeriksaanBumil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'tgl_periksa DATE NOT NULL DEFAULT current_timestamp',
            'dibuat DATE NOT NULL DEFAULT current_timestamp',
            'registrar' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'gravida' => [
                'type' => 'INT',
                'default' => 1,
                'constraint' => 3
            ],
            'paritas' => [
                'type' => 'INT',
                'default' => 0,
                'constraint' => 3
            ],
            'abortus' => [
                'type' => 'INT',
                'default' => 0,
                'constraint' => 3
            ],
            'hidup' => [
                'type' => 'INT',
                'default' => 0,
                'constraint' => 3
            ],
            'hpht' => [
                'type' => 'DATE',
                'null' => true
            ],
            'hpl' => [
                'type' => 'DATE',
                'null' => true
            ],
            'persalinan_sebemulnya' => [
                'type' => 'DATE',
                'null' => true
            ],
            'bb' => [
                'type' => 'INT',
                'null' => true,
            ],
            'tb' => [
                'type' => 'INT',
                'null' => true
            ],
            'buku_kia' => [
                'type' => 'ENUM',
                'default' => '0',
                'constraint' => ['1', '0']
            ],
            'riwayat_komplikasi' => [
                'type' => 'VARCHAR', 
                'constraint' => 115,
                'null' => true
            ],
            'penyakit' => [
                'type' => 'VARCHAR', 
                'constraint' => 115,
                'null' => true
            ],
            'persalinan_tgl' => [
                'type' => 'DATE',
                'null' => true
            ],
            'persalinan_penolong' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => true
            ],
            'persalinan_pendamping' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => true
            ],
            'persalinan_tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => true
            ],
            'persalinan_transportasi' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => true
            ],
            'persalinan_pendonor' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => true
            ],
            'persalinan_kunjungan_rumah' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
                'null' => true
            ],
            'persalinan_kondisi_rumah' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
                'null' => true
            ],
            'persalinan_persedian' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
                'null' => true
            ],
            
        ]);
        $this->forge->addKey('id', true, true);
        $this->forge->createTable('kunjungan_bumil');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan_bumil');
    }
}
