<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'dev',
                'email'    => 'dev@mail.com',
                'nama_lengkap' => null,
                'password' => password_hash('dev', PASSWORD_DEFAULT)
            ],
            [
                'username' => 'kamscode',
                'email'    => 'kamscode@mail.com',
                'nama_lengkap' => 'Fathurrahman',
                'password' => password_hash('kamscode', PASSWORD_DEFAULT)
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
