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
        'darah' => 'golongan_darah',
        'hp' => 'hp',
        'kartu' => 'kartu_kesehatan',
        'no' => 'nomor',
        'rt' => 'rt'
    ];

    public array $periksa_bumil = [
        'tgl' => 'tgl_periksa',
        'gravida' => 'gravida',
        'paritas' => 'paritas',
        'abortus' => 'paritas',
        'hidup' => 'hidup',
        'hpht' => 'hpht',
        'hpl' => 'hpl',
        'sebelum' => 'persalinan_sebemulnya',
        'bb' => 'bb',
        'tb' => 'tb',
        'buku_kia' => 'buku_kia',
        'komplikasi' => 'riwayat_komplikasi',
        'penyakit' => 'penyakit',
        'tgl_persalinan' => 'persalinan_tgl',
        'penolong' => 'persalinan_penolong',
        'pendamping' => 'persalinan_pendamping',
        'tempat' => 'persalinan_tempat',
        'transport' => 'persalinan_transportasi',
        'donor' => 'persalinan_pendonor',
        'kunjungan' => 'persalinan_kunjungan_rumah',
        'kondisi_rumah' => 'persalinan_kondisi_rumah',
        'persediaan' => 'persalinan_persedian',
        'posyandu' => 'posyandu',
        'dukun' => 'dukun'
    ];

    public array $lansia = [
        'id' => 'id',
        'dibuat' => 'dibuat',
        'nama' => 'nama',
        'alamat' => 'alamat',
        'ttl' => 'tanggal_lahir',
        'estimasi' => 'estimasi_ttl',
        'nik' => 'nik',
    ];
    public array $anak = [
        'id' => 'id',
        'dibuat' => 'dibuat',
        'nama' => 'nama',
        'alamat' => 'alamat',
        'ttl' => 'tanggal_lahir',
        'estimasi' => 'estimasi_ttl' ,
        'kelamin' => 'kelamin',
        'bbl' => 'bbl',
        'ibu' => 'ibu',
        'ayah' => 'ayah',
        'akb' => 'akb'
    ];
}