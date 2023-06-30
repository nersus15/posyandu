<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BumilModel;
use App\Models\KunjunganBumil;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use Faker\Guesser\Name;

class Bumil extends BaseController
{
    protected $bumilModel;
    public function __construct()
    {
        $this->bumilModel = new BumilModel();
    }
    public function index()
    {
        $dataBumil = reversemapping('bumil', $this->bumilModel->where('registrar', sessiondata('login', 'username'))->findAll(), [], [], true);
        $fabricator = new Fabricator($this->bumilModel, null, 'id_ID');
        // $faker->format($formatters);
        // $dataBumil += $fabricator->make(100);
        $session = session();
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
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-bumil',
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
                            'Alamat' => 'alamat',
                            'Pendidikan' => 'pendidikan',
                            'Pekerjaan' => 'pekerjaan',
                            'Agama' => 'agama',
                            'Action' => function ($data) {
                                return '<div style="margin:auto" class="row"><a href="' . base_url('bumil/kunjungan/' . $data['id']) . '" class="btb btn-xs btn-info">Periksa</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('bumil/update/' . $data['id']) . '" class="btb btn-xs btn-warning">Update</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('bumil/delete/' . $data['id']) . '" class="btb btn-xs btn-danger">Delete</a></div>';
                            }
                        ],
                        'data' => $dataBumil
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    public function kunjungan($id = null)
    {
        if (empty($id)) {
            return view('errors/html/error_404', ['code' => '404', 'message' => "ID Ibu hamil harus disebutkanb "]);
        }
        $dataBumil = $this->bumilModel->find($id);
        if (empty($dataBumil))
            return view('errors/html/error_404', ['code' => '404', 'message' => "Data dengan ID $id tidak ditemukan"]);
        $dataBumil = reversemapping('bumil', $dataBumil);
        $kunjunganBumilModel = new KunjunganBumil();
        $dataBumil['kunjungan'] = $kunjunganBumilModel->where('ibu', $id)->orderBy('dibuat', 'DESC')->findAll();


        $data = [
            'dataHeader' => [
                'title' => 'Data Pemeriksaan Ibu ' . $dataBumil['nama'],
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
                        'buttons' => [
                            [
                                'text' => 'Periksa',
                                'action' => 'function( e, dt, node, config ){location.href = basepath + "bumil/periksa/' . $id . '";}'
                            ]
                        ],
                        'desc' => null,
                        'dtid' => 'dt-kunjungan-bumil',
                        'header' => [
                            'Tanggal' => 'dibuat',
                            'Obstetrik' => function ($rec) {
                                return 'G' . $rec['gravida'] . ' P' . $rec['paritas'] . ' A' . $rec['abortus'] . ' Hidup ' . $rec['hidup'];
                            }
                        ],
                        'data' => $dataBumil['kunjungan']
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
    public function add()
    {
        return $this->form();
    }

    public function post_add()
    {
        $post = $this->request->getPost();
        $message = null;
        if ($post['ingat_ttl'] == 0 && !is_numeric($post['umur'])) {
            $message = "Umur harus angka";
        } else {
            $estimasi = '0';
            if ($post['ingat_ttl'] == 0) {
                $hariIni = time();
                $umur = intval($post['umur']) * (60 * 60 * 24 * 365.25);
                $ttl = waktu($hariIni - $umur, MYSQL_DATE_FORMAT);
                $estimasi = '1';
            }
            $def = array(
                'ttl' => $ttl
            );
            $data = fieldmapping('bumil', $post, $def);
            $data['id'] = random(10);
            $data['dibuat'] = waktu();
            $data['ttl_estimasi'] = $estimasi;
            $data['registrar'] = sessiondata('login', 'username');

            try {
                $this->bumilModel->insert($data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect(empty($message) ? 'bumil' : 'bumil/add')->with('response', $message)->with('bumilData', $post);
    }

    public function update($id)
    {
        return $this->form($id);
    }

    public function delete($id)
    {
        $data = $this->bumilModel->find($id);
        $message = 'Berhasil menghapus data dengan id #' . $id;
        if (empty($data))
            $message = 'Data tidak ditemukan';
        else
            $this->bumilModel->delete($id);

        return redirect('bumil')->with('response', $message);
    }

    public function set($id)
    {
        $post = $this->request->getPost();
        $message = null;
        if ($post['ingat_ttl'] == 0 && !is_numeric($post['umur'])) {
            $message = "Umur harus angka";
        } else {
            $estimasi = '0';
            if ($post['ingat_ttl'] == 0) {
                $hariIni = time();
                $umur = intval($post['umur']) * (60 * 60 * 24 * 365.25);
                $ttl = waktu($hariIni - $umur, MYSQL_DATE_FORMAT);
                $estimasi = '1';
            }
            $def = array(
                'ttl' => $ttl ?? null
            );
            $data = fieldmapping('bumil', $post, $def);
            $data['ttl_estimasi'] = $estimasi;

            try {
                $this->bumilModel->update($id, $data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect(empty($message) ? 'bumil' : ('bumil/update/' . $id))->with('response', $message)->with('bumilData', $post);
    }

    private function form($id = null)
    {
        $dataBumil = [];
        if (!empty($id)) {
            $dataBumil = $this->bumilModel->find($id);
            if (empty($dataBumil))
                return view('errors/html/error_404', ['code' => '404', 'message' => "Data dengan ID $id tidak ditemukan"]);
            $dataBumil = reversemapping('bumil', $dataBumil);
        }

        $data = [
            'dataHeader' => [
                'title' => (empty($id) ? 'Tambah' : 'Update') . ' Data Ibu Hamil',
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
                    'data' => ['dataBumil' => $dataBumil, 'mode' => empty($id) ? 'baru' : 'edit']
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    function periksa($id = null)
    {
        $bumil = $this->bumilModel->find($id);
        if (empty($bumil))
            return view('errors/html/error_404', ['code' => '404', 'message' => "Data dengan ID $id tidak ditemukan"]);
        return $this->formPeriksa($id);
    }
    function post_periksa()
    {
        $kunjunganBumil = new KunjunganBumil();
        $post = $this->request->getPost();
        $def = [
            'tgl_periksa' => [null => waktu(null, MYSQL_DATE_FORMAT)]
        ];
        $peta = [];
        $data = fieldmapping('periksa_bumil', $post, $def, $peta);
        $data['id'] = random(8);
        $data['dibuat'] = waktu();
        $data['registrar'] = sessiondata('login', 'username');
        $data['ibu'] = $post['ibu'];

        try {
            $kunjunganBumil->insert($data);
        } catch (\Throwable $th) {
            $message = htmlspecialchars($th->getMessage());
        }
        return redirect((empty($message) ? 'bumil/kunjungan/' : 'bumil/periksa/') . $post['ibu'] )->with('response', $message)->with('bumilData', $post);
    }
    function set_periksa($id = null)
    {
    }
    function update_periksa($id = null)
    {
    }
    function delete_periksa($id = null)
    {
    }

    private function formPeriksa($ibu = null, $id = null)
    {
        $dataKunjungan = [];

        if (!empty($id)) {
            $kunjunganBumil = new KunjunganBumil();
            $dataKunjungan = $kunjunganBumil->find($id);
        }

        $data = [
            'dataHeader' => [
                'title' => (empty($id) ? 'Tambah' : 'Update') . ' Data Ibu Hamil',
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
                    'view' => 'pages/periksa_bumil',
                    'data' => ['dataKunjungan' => $dataKunjungan, 'ibu' => $ibu, 'mode' => empty($id) ? 'baru' : 'edit']
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
}
