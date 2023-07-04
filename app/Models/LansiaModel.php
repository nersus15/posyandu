<?php

namespace App\Models;

use CodeIgniter\Model;

class LansiaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lansia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'registrar',
        'dibuat',
        'nama',
        'alamat',
        'tanggal_lahir',
        'estimasi_ttl',
        'nik',
        'pemeriksaan'
    ];

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

    function get_pemeriksaan($id = null, $lansia, $tahun = null)
    {
        $data = [];
        $q = $this->db->table('lansia')
            ->select('lansia.*, kunjungan_lansia.bulan, kunjungan_lansia.berat, w1.nama kecamatan, w2.nama desa, kunjungan_lansia.id idkunjungan')
            ->join('wilayah w1', 'w1.id = CONCAT(SUBSTR(lansia.alamat, 1, 8), ".0000")', 'inner')
            ->join('wilayah w2', 'w2.id = lansia.alamat', 'inner')
            ->join('kunjungan_lansia', 'lansia.id = kunjungan_lansia.lansia', 'inner');
        if(!empty($id))
            $q->where('kunjungan_lansia.id', $id);

        if(!empty($lansia))
            $q->where('lansia.id', $lansia);
        
        if(!empty($tahun))
            $q->like('kunjungan_lansia.bulan', $tahun, 'after');
        $tmp = $q->get()->getResultObject();
        foreach ($tmp as $v) {
            if(isset($data[$v->id])){
                $data[$v->id]['pemeriksaan'][$v->bulan]['berat'] = $v->berat;
                $data[$v->id]['pemeriksaan'][$v->bulan]['id'] = $v->idkunjungan;
            }else{
                $data[$v->id] = [
                    'id' => $v->id,
                    'registrar' => $v->registrar,
                    'dibuat' => $v->dibuat,
                    'nama' => $v->nama,
                    'alamat' => 'Desa ' . $v->desa . ', Kec. ' . $v->kecamatan,
                    'tanggal_lahir' => $v->tanggal_lahir,
                    'estimasi_ttl' => $v->estimasi_ttl,
                    'nik' => $v->nik,
                    'pemeriksaan' => [
                        $v->bulan => [
                            'berat' => $v->berat,
                            'id' => $v->idkunjungan
                        ]
                    ]
                    ];
            }
        }
        return $data;
    }
}
