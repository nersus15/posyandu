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
                'nama_lengkap' => 'Fathurrahman',
                'password' => password_hash('bidan', PASSWORD_DEFAULT),
                'faskes' => 'Rensing',
                'role' => 'bidan',
                'wilayah_kerja' => '52.03.19.0000'
            ],
            [
                'username' => 'kader',
                'email'    => 'kader@mail.com',
                'nama_lengkap' => 'Fathurrahman',
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
