<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'kamscode',
                'email'    => 'kamscode@mail.com',
                'nama_lengkap' => 'Fathurrahman',
                'password' => password_hash('kamscode', PASSWORD_DEFAULT),
                'faskes' => 'Lepak',
                'role' => 'petugas'
            ],
            [
                'username' => 'kader',
                'email'    => 'kader@mail.com',
                'nama_lengkap' => 'Fathurrahman',
                'role' => 'kader',
                'password' => password_hash('kader', PASSWORD_DEFAULT),
                'faskes' => 'Lepak'
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
