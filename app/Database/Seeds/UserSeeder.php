<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'bidan',
                'email'    => 'bidan@mail.com',
                'nama_lengkap' => 'Bidan',
                'password' => password_hash('bidan', PASSWORD_DEFAULT),
                'faskes' => 'Rensing',
                'role' => 'bidan',
                'wilayah_kerja' => '52.03.19.0000'
            ],
            [
                'username' => 'admin',
                'email'    => 'admin@mail.com',
                'nama_lengkap' => 'Admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'faskes' => '',
                'role' => 'admin',
                'wilayah_kerja' => ''
            ],
            [
                'username' => 'kader',
                'email'    => 'kader@mail.com',
                'nama_lengkap' => 'Kader',
                'role' => 'kader',
                'password' => password_hash('kader', PASSWORD_DEFAULT),
                'faskes' => 'Rensing',
                'wilayah_kerja' => '52.03.19.2001'
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
