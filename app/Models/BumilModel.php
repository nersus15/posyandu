<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;

class BumilModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bumils';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    public function fake(Generator &$faker){
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
}
