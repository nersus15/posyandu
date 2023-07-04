<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LansiaModel;
use App\Models\WilayahModel;

class Lansia extends BaseController
{
    protected $lansiaModel;
    public function __construct()
    {
        $this->lansiaModel = new LansiaModel();
    }
    public function index()
    {
        $dataLansia = reversemapping('bumil', $this->lansiaModel->where('registrar', sessiondata('login', 'username'))->findAll(), [], [], true);
        $session = session();
        $wilayahModel = new WilayahModel();
        $wilayah = $wilayahModel->findAll();
        $wilayah = array_combine(array_column($wilayah, 'id'), array_column($wilayah, 'nama'));
        $data = [
            'dataHeader' => [
                'title' => 'Data Lansia',
                'extra_js' => [
                    "vendor/adminlte/plugins/datatables/jquery.dataTables.min.js",
                    "vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
                    "vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js",
                    "vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
                    "vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js",
                    "vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
                    "vendor/adminlte/plugins/jszip/jszip.min.js",
                    "vendor/adminlte/plugins/pdfmake/pdfmake.min.js",
                    "vendor/adminlte/plugins/pdfmake/vfs_fonts.js",
                    "vendor/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js",
                    "vendor/adminlte/plugins/datatables-buttons/js/buttons.print.min.js",
                    "vendor/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js",
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'lansia'
            ],
            'contents' => [
                'lansia' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'adaTambah' => true,
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-lansia',
                        'header' => [
                            'No' => function ($data, $key) {
                                return $key + 1;
                            },
                            'Nama' => 'nama',
                            'Nama Suami' => 'suami',
                            'Tanggal Lahir' => function ($data) {
                                $badge = null;
                                if ($data['ttl_estimasi'] == 1) {
                                    $badge = '<span class="ml-2 badge bg-info badge-xs">Estimasi</span>';
                                }
                                return $data['ttl'] . $badge;
                            },
                            'Alamat Domisili' => 'domisili',
                            'Alamat' => function ($rec) use ($wilayah) {
                                $desa = $wilayah[$rec['alamat']];
                                $kecamatan = $wilayah[substr($rec['alamat'], 0, 8) . '.0000'];
                                return 'Desa ' . $desa . ', Kec. ' . $kecamatan;
                            },
                            'Pendidikan' => 'pendidikan',
                            'Pekerjaan' => 'pekerjaan',
                            'Agama' => 'agama',
                            'Action' => function ($data) {
                                return '<div style="margin:auto" class="row"><a href="' . base_url('lansia/kunjungan/' . $data['id']) . '" class="btb btn-xs btn-info">Periksa</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('lansia/update/' . $data['id']) . '" class="btb btn-xs btn-warning">Update</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('lansia/delete/' . $data['id']) . '" class="btb btn-xs btn-danger">Delete</a></div>';
                            }
                        ],
                        'data' => $dataLansia
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
}
