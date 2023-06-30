<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganBumil extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kunjungan_bumil';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'tgl_periksa',
        'ibu',
        'registrar',
        'gravida',
        'paritas',
        'abortus',
        'hidup',
        'hpht',
        'hpl',
        'persalinan_sebemulnya',
        'bb',
        'tb',
        'buku_kia',
        'riwayat_komplikasi',
        'penyakit',
        'persalinan_tgl',
        'persalinan_penolong',
        'persalinan_pendamping',
        'persalinan_tempat',
        'persalinan_transportasi',
        'persalinan_pendonor',
        'persalinan_kunjungan_rumah',
        'persalinan_kondisi_rumah',
        'persalinan_persedian',
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
}
