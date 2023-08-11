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
            ->select('anak.*, kunjungan_anak.nama_pemeriksa, kunjungan_anak.bulan, kunjungan_anak.berat, kunjungan_anak.tinggi, w1.nama kecamatan, w2.nama desa, kunjungan_anak.id idkunjungan')
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
                $data[$v->id]['pemeriksaan'][$v->bulan]['nama_pemeriksa'] = $v->nama_pemeriksa;
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
        $tmp = $this->select('anak.id, kunjungan_anak.dibuat, ibu, nama, kelamin, alamat, MONTH(kunjungan_anak.bulan) bulan, tanggal_lahir ttl, kunjungan_anak.tinggi tb, kunjungan_anak.berat bb')
            ->join('kunjungan_anak', "kunjungan_anak.anak = anak.id AND kunjungan_anak.bulan LIKE '$tahun%'")
            ->where('kunjungan_anak.registrar', sessiondata('login', 'username'))
            ->findAll();

        $data = [];
        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach($daftarBulan as $k => $bulan){
            $data[$k + 1] = [];
        }
        foreach ($tmp as $v) {
            $v = (object) $v;
            $umur = null;
            if (!empty($v->ttl)) {
                $ttl = date_create($v->ttl);
                $sekarang = date_create($v->dibuat);
                $diff = date_diff($ttl, $sekarang);

                $umur = ($diff->y <= 0 ? '' : $diff->y . ' Tahun, ') . ($diff->m <= 0 ? '' : $diff->m . ' Bulan, ') . $diff->d . ' Hari';
            }

            $data[$v->bulan][$v->id] = [
                'ibu' => $v->ibu,
                'nama' => $v->nama,
                'alamat' => $v->alamat,
                'kelamin' => $v->kelamin,
                'umur' => $umur,
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
