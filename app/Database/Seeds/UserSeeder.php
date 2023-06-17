<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'dev',
            'email'    => 'dev@mail.com',
            'password' => password_hash('kambing15', PASSWORD_DEFAULT)
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
