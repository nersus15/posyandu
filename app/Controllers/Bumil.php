<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BumilModel;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use Faker\Guesser\Name;

class Bumil extends BaseController
{
    public function index()
    {
        $dataBumil = [];
        $bumilModel = new BumilModel();
        $fabricator = new Fabricator($bumilModel, null, 'id_ID');

        // $faker->format($formatters);
        $dataBumil = $fabricator->make(100);
        $data = [
            'dataHeader' => [
                'title' => 'Data Ibu Hamil',
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
                'activeMenu' => 'bumil'
            ],
            'contents' => [
                'bumil' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'adaTambah' => true,
                        'dtid' => 'dt-bumil',
                        'header' => [
                            'No' => function ($data, $key) {
                                return $key + 1;
                            },
                            'Nama' => 'nama',
                            'Nama Suami' => 'suami',
                            'Tanggal Lahir' => 'ttl',
                            'Alamat Domisili' => 'domisili',
                            'Alamat' => 'alamat',
                            'Pendidikan' => 'pendidikan',
                            'Pekerjaan' => 'pekerjaan',
                            'Agama' => 'agama'
                        ],
                        'data' => $dataBumil
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
    public function add()
    {
        $dataBumil = [];
        $bumilModel = new BumilModel();
        $fabricator = new Fabricator($bumilModel, null, 'id_ID');

        // $faker->format($formatters);
        $dataBumil = $fabricator->make(100);
        $data = [
            'dataHeader' => [
                'title' => 'Tambah Data Ibu Hamil',
                'extra_js' => [
                    'vendor/adminlte/plugins/moment/moment.min.js',
                    "vendor/adminlte/plugins/daterangepicker/daterangepicker.js",
                    "vendor/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
                    'vendor/adminlte/plugins/inputmask/jquery.inputmask.min.js'

                ],
                'extra_css' => [
                    'vendor/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                    'vendor/adminlte/plugins/daterangepicker/daterangepicker.css'
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'bumil'
            ],
            'contents' => [
                'bumil' => [
                    'view' => 'pages/tambah_bumil',
                    'data' => []
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    public function post_add()
    {
        $post = $this->request->getPost();
        $message = null;
        if($post['ingat_ttl'] == 0 && !is_numeric($post['umur']))
            $message = "Umur harus angka";
            
        return redirect('bumil/add')->with('loginMessage', $message)->with('bumilData', $post);
    }
}
