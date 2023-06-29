<?php
namespace Config\Additional;

use CodeIgniter\Config\BaseConfig;

class Forms extends BaseConfig{
    public array $bumil = [
        'nama' => 'nama',
        'suami' => 'nama_suami',
        'ttl' => 'tanggal_lahir',
        'domisili' => 'domisili',
        'alamat' => 'alamat',
        'pendidikan' => 'pendidikan',
        'pekerjaan' => 'pekerjaan',
        'agama' => 'agama',
        'ttl_estimasi' => 'ttl_estimasi',
        'id' => 'id',
    ];
}