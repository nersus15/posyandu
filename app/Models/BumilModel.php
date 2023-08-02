<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;

class BumilModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bumil';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'nama',
        'nama_suami',
        'tanggal_lahir',
        'domisili',
        'alamat',
        'pendidikan',
        'pekerjaan',
        'agama',
        'registrar',
        'ttl_estimasi',
        'golongan_darah',
        'hp',
        'kartu_kesehatan',
        'nomor',
        'rt',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function fake(Generator &$faker)
    {
        return [
            'nama' => $faker->name('female'),
            'suami' => $faker->name('male'),
            'ttl' => $faker->date('Y-m-d', '2000-01-01'),
            'domisili' => $faker->address(),
            'alamat' => $faker->address(),
            'pendidikan' => 'S1',
            'pekerjaan' => $faker->jobTitle(),
            'agama' => 'Islam'
        ];
    }
    function getBYWilker($wilker){
        $prefWil = prefiks_wilayah($wilker);
        return $this->join('users', 'bumil.registrar = users.username')
            ->like('wilayah_kerja', $prefWil, 'after')->select('bumil.*')->find();
    }

    function getLaporan($tahun = 2023){
        return  [];
    }
}
