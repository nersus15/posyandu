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
    function getBYWilker($wilker)
    {
        $prefWil = prefiks_wilayah($wilker);
        return $this->join('users', 'bumil.registrar = users.username')
            ->like('wilayah_kerja', $prefWil, 'after')->select('bumil.*')->find();
    }

    function getLaporan($tahun = 2023)
    {
        $wilayah = getWil();
        $tmp = $this->select('bumil.id, nama, nama_suami, alamat, MONTH(kunjungan_bumil.tgl_periksa) bulan, tanggal_lahir ttl, ttl_estimasi estimasi, kunjungan_bumil.gravida, kunjungan_bumil.usia_kehamilan, kunjungan_bumil.tb, kunjungan_bumil.bb')
            ->join('kunjungan_bumil', "kunjungan_bumil.ibu = bumil.id AND kunjungan_bumil.tgl_periksa LIKE '$tahun%'")
            ->findAll();

        $data = [];
        $tmp2 = [];

        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach($daftarBulan as $k => $bulan){
            $data[$k + 1] = [];
        }
        foreach ($tmp as $v) {
            $v = (object) $v;
            $usiaKehamilan = null;
            if (!empty($v->usia_kehamilan)) {
                $bulan = floor($v->usia_kehamilan / 30);
                $hari = $v->usia_kehamilan % 30;
                $usiaKehamilan = ($bulan >= 1 ? $bulan . ' Bulan, ' : '') . $hari . ' Hari';
            }

            $data[$v->bulan][$v->id] = [
                'nama' => $v->nama,
                'suami' => $v->nama_suami,
                'alamat' => $v->alamat,
                'ttl' => $v->ttl,
                'gravida' => $v->gravida,
                'usia_kehamilan' => $usiaKehamilan,
                'hasil' => $v->tb . '/' . $v->bb
            ];
        }

        foreach ($data as $bulan => $d) {
            foreach ($d as $key => $v) {
                // Perbaiki Alamat
                $alamat = $v['alamat'];
                if (level_wilayah($alamat) == 3)
                    $data[$bulan][$key]['alamat'] = 'Kec. ' . $wilayah['kecamatan'][$alamat];
                elseif (level_wilayah($alamat) == 4)
                    $data[$bulan][$key]['alamat'] = 'Desa ' . $wilayah['desa'][$alamat] . ', Kec.' . $wilayah['kecamatan'][substr($alamat, 0, 8) . '.0000'];
            }
        }
        return  $data;
    }
}
