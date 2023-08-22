<?php
namespace Config\Additional;

use CodeIgniter\Config\BaseConfig;

class Forms extends BaseConfig{
    public array $user = [
        'username' => 'username',
        'nama' => 'nama_lengkap',
        'email' => 'email',
        'alamat' => 'alamat',
        'hp' => 'hp',
        'wilker' => 'wilayah_kerja',
        'dibuat' => 'dibuat',
        'faskes' => 'faskes',
        'photo' => 'photo',
        'role' => 'role'
    ];
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

    public array $periksa_bumil_bidan = [
        'tgl' => 'tgl_periksa',
        'pemeriksa' => 'nama_pemeriksa',
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

    public $periksa_bumil_kader = [
        'tgl' => 'tgl_periksa',
        'pemeriksa' => 'nama_pemeriksa',
        'gravida' => 'gravida',
        'paritas' => 'paritas',
        'abortus' => 'paritas',
        'bb' => 'bb',
        'tb' => 'tb',
        'lila' => 'lila',
        'fundus' => 'fundus',
        'usia_hamil' => 'usia_kehamilan',
        'ttd' => 'ttd',
        'hb' => 'hb'
    ];
    public $periksa_bumil_admin = [
        'tgl' => 'tgl_periksa',
        'pemeriksa' => 'nama_pemeriksa',
        'gravida' => 'gravida',
        'paritas' => 'paritas',
        'abortus' => 'paritas',
        'bb' => 'bb',
        'tb' => 'tb',
        'lila' => 'lila',
        'fundus' => 'fundus',
        'usia_hamil' => 'usia_kehamilan',
        'ttd' => 'ttd',
        'hb' => 'hb'
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