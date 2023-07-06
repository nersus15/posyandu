<?php

namespace App\Models;

use CodeIgniter\Model;

class AnakModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'anak';
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
        'estimasi_ttl' ,
        'kelamin',
        'bbl',
        'ibu',
        'ayah',
        'akb'
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

    function findByUmur($umur = null){
        if(!in_array($umur, ['05', '611', '1223', '2459']))
            $umur = null;
        $data = [];
        if(!empty($umur)){
            $tglIni = waktu(null, MYSQL_DATE_FORMAT);
            $satuBulan = 30 * 24 * 60 *60;

            $mulai = $tglIni;
            $selesai = $tglIni;
            switch($umur){
                case '05':
                    $mulai = waktu(time() - ($satuBulan * 5), MYSQL_DATE_FORMAT);
                    break;
                case '611':
                    $mulai = waktu(time() - ($satuBulan * 11), MYSQL_DATE_FORMAT);
                    $selesai = waktu(time() - ($satuBulan * 6), MYSQL_DATE_FORMAT);
                    break;
                case '1223':
                    $mulai = waktu(time() - ($satuBulan * 23), MYSQL_DATE_FORMAT);
                    $selesai = waktu(time() - ($satuBulan * 12), MYSQL_DATE_FORMAT);
                    break;
                case '2459':
                    $mulai = waktu(time() - ($satuBulan * 59), MYSQL_DATE_FORMAT);
                    $selesai = waktu(time() - ($satuBulan * 24), MYSQL_DATE_FORMAT);
                    break;
            }

           $data = $this->where('registrar', sessiondata('login', 'username'))->where("tanggal_lahir BETWEEN '$mulai' AND '$selesai'")->findAll();
        }else{
            $data = $this->where('registrar', sessiondata('login', 'username'))->findAll();
        }
        return $data;
    }

    function get_pemeriksaan($id = null, $anak, $tahun = null)
    {
        $data = [];
        $onJoinKunjungan = 'anak.id = kunjungan_anak.anak';
        if(!empty($tahun)){
            $onJoinKunjungan .= ' AND `kunjungan_anak`.`bulan` LIKE "' . $tahun . '%"';
        }
        $q = $this->db->table('anak')
            ->select('anak.*, kunjungan_anak.bulan, kunjungan_anak.berat, kunjungan_anak.tinggi, w1.nama kecamatan, w2.nama desa, kunjungan_anak.id idkunjungan')
            ->join('wilayah w1', 'w1.id = CONCAT(SUBSTR(anak.alamat, 1, 8), ".0000")', 'inner')
            ->join('wilayah w2', 'w2.id = anak.alamat', 'inner')
            ->join('kunjungan_anak', $onJoinKunjungan, 'left');

        if(!empty($id))
            $q->where('kunjungan_anak.id', $id);

        if(!empty($anak))
            $q->where('anak.id', $anak);
        
        // var_dump($q->getCompiledSelect());die;
        $tmp = $q->get()->getResultObject();
        foreach ($tmp as $v) {
            if(isset($data[$v->id])){
                $data[$v->id]['pemeriksaan'][$v->bulan]['berat'] = $v->berat;
                $data[$v->id]['pemeriksaan'][$v->bulan]['tinggi'] = $v->tinggi;
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
                    'ibu' => $v->ibu,
                    'pemeriksaan' => []
                ];
                if(!empty($v->bulan)){
                    $data[$v->id]['pemeriksaan'][$v->bulan] = [
                        'berat' => $v->berat,
                        'tinggi' => $v->tinggi,
                        'id' => $v->idkunjungan
                    ];
                }
            }
        }
        return $data;
    }
}
