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
            'faskes' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'default' => null,
                'null' => true,
            ],
            'tgl_periksa DATE NOT NULL DEFAULT current_timestamp',
            'dibuat DATE NOT NULL DEFAULT current_timestamp',
            'nama_pemeriksa' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'posyandu' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'dukun' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
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
                'default' => '',
                'constraint' => ['', '1', '0']
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

            'lila' => [
                'type' => 'INT',
                'null' => true
            ],
            'fundus' => [
                'type' => 'INT',
                'null' => true
            ],
            'hb' => [
                'type' => 'INT',
                'null' => true
            ],
            'usia_kehamilan' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'dalam hari'
            ],
            'ttd' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => true,
                'comment' => ''
            ],

        ]);
        $this->forge->addForeignKey('ibu', 'bumil', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id', true, true);
        $this->forge->createTable('kunjungan_bumil');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan_bumil');
    }
}
