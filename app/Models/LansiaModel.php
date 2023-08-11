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

    function get_pemeriksaan($id = null, $lansia = null, $tahun = null)
    {
        $data = [];
        $onJoinKunjungan = 'lansia.id = kunjungan_lansia.lansia';
        if(!empty($tahun)){
            $onJoinKunjungan .= ' AND `kunjungan_lansia`.`bulan` LIKE "' . $tahun . '%"';
        }
        $q = $this->db->table('lansia')
            ->select('lansia.*, kunjungan_lansia.nama_pemeriksa, kunjungan_lansia.bulan, kunjungan_lansia.berat, w1.nama kecamatan, w2.nama desa, kunjungan_lansia.id idkunjungan')
            ->join('wilayah w1', 'w1.id = CONCAT(SUBSTR(lansia.alamat, 1, 8), ".0000")', 'inner')
            ->join('wilayah w2', 'w2.id = lansia.alamat', 'inner')
            ->join('kunjungan_lansia', $onJoinKunjungan, 'left');

        if(!empty($id))
            $q->where('kunjungan_lansia.id', $id);

        if(!empty($lansia))
            $q->where('lansia.id', $lansia);
        
        // var_dump($q->getCompiledSelect());die;
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
                    'pemeriksaan' => []
                ];
                if(!empty($v->bulan)){
                    $data[$v->id]['pemeriksaan'][$v->bulan] = [
                        'berat' => $v->berat,
                        'id' => $v->idkunjungan,
                        'nama_pemeriksa' => $v->nama_pemeriksa
                    ];
                }
            }
        }
        return $data;
    }
    function getLaporan($tahun = 2023)
    {
        $wilayah = getWil();
        $tmp = $this->select('lansia.id, lansia.nama, alamat, MONTH(kunjungan_lansia.bulan) bulan, tanggal_lahir ttl, nik, kunjungan_lansia.berat bb')
            ->join('kunjungan_lansia', "kunjungan_lansia.lansia = lansia.id AND kunjungan_lansia.bulan LIKE '$tahun%'")
            ->where('kunjungan_lansia.registrar', sessiondata('login', 'username'))
            ->findAll();

        $data = [];
        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach($daftarBulan as $k => $bulan){
            $data[$k + 1] = [];
        }
        foreach ($tmp as $v) {
            $v = (object) $v;
            $data[$v->bulan][$v->id] = [
                'nama' => $v->nama,
                'alamat' => $v->alamat,
                'ttl' => $v->ttl,
                'nik' => $v->nik,
                'hasil' => $v->bb
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
