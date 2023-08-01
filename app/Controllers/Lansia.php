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
        $dataLansia = reversemapping('lansia', $this->lansiaModel->where('registrar', sessiondata('login', 'username'))->findAll(), [], [], true);
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
            'dataFooter' => [
                'extra_js' => [
                    'js/pages/kunjungan_lansia.js'
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'lansia'
            ],
            'contents' => [
                'lansia' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'buttons' => [
                            [
                                'text' => 'Tambah Data',
                                'action' => 'function( e, dt, node, config ){location.href = basepath + "lansia/add"}'
                            ]
                        ],
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-lansia',
                        'header' => [
                            'No' => function ($data, $key) {
                                return $key + 1;
                            },
                            'Nama' => 'nama',
                            'Alamat' => function ($rec) use ($wilayah) {
                                $desa = $wilayah[$rec['alamat']];
                                $kecamatan = $wilayah[substr($rec['alamat'], 0, 8) . '.0000'];
                                return 'Desa ' . $desa . ', Kec. ' . $kecamatan;
                            },
                            'Tanggal Lahir' => function ($data) {
                                $badge = null;
                                if ($data['estimasi'] == 1) {
                                    $badge = '<span class="ml-2 badge bg-info badge-xs">Estimasi</span>';
                                }
                                return $data['ttl'] . $badge;
                            },
                            'NIK' => 'nik',
                            'Action' => function ($data) {
                                return '<div style="margin:auto" class="row"><a href="' . base_url('lansia/kunjungan/' . $data['id'] . '/' . date('Y')) . '" class="btb btn-xs btn-info">Periksa</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('lansia/update/' . $data['id']) . '" class="btb btn-xs btn-warning">Update</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('lansia/delete/' . $data['id']) . '" class="btb btn-hapus-lansia btn-xs btn-danger">Delete</a></div>';
                            }
                        ],
                        'data' => $dataLansia
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    public function add()
    {
        return $this->forms();
    }
    public function update($id = null)
    {
        return $this->forms($id);
    }
    public function delete($id = null)
    {
        $data = $this->lansiaModel->find($id);
        $message = 'Berhasil menghapus data dengan id #' . $id;
        if (empty($data))
            $message = 'Data tidak ditemukan';
        else
            $this->lansiaModel->delete($id);

        return redirect('lansia')->with('response', $message);
    }
    public function set($id = null)
    {
        $post = $this->request->getPost();
        $message = null;
        $ttl = waktu(null, MYSQL_DATE_FORMAT);
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
            $data = fieldmapping('lansia', $post, $def);
            $data['estimasi_ttl'] = $estimasi;

            try {
                $this->lansiaModel->update($id, $data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect()->to(base_url(empty($message) ? 'lansia' : 'lansia/add'))->with('response', $message)->with('lansiaData', $post);
    }
    public function save()
    {
        $post = $this->request->getPost();
        $message = null;
        $ttl = waktu(null, MYSQL_DATE_FORMAT);
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
            $data = fieldmapping('lansia', $post, $def);
            $data['id'] = random(8);
            $data['dibuat'] = waktu();
            $data['estimasi_ttl'] = $estimasi;
            $data['registrar'] = sessiondata('login', 'username');

            try {
                $this->lansiaModel->insert($data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect()->to(base_url(empty($message) ? 'lansia' : 'lansia/add'))->with('response', $message)->with('lansiaData', $post);
    }
    public function forms($id = null)
    {
        $dataLansia = [];
        if (!empty($id)) {
            $dataLansia = $this->lansiaModel->find($id);
            if (empty($dataLansia))
                return view('errors/html/error_404', ['code' => '404', 'message' => "Data dengan ID $id tidak ditemukan"]);
            $dataLansia = reversemapping('lansia', $dataLansia);
        }
        $wilayahModel = new WilayahModel();
        $tmp = $wilayahModel->findAll();
        $wilayah = [];
        $kecamatan = array_filter($tmp, function ($arr) {
            return $arr['level'] == 3;
        });
        $kecamatan = array_combine(array_column($kecamatan, 'id'), array_column($kecamatan, 'nama'));
        foreach ($tmp as $w) {
            if ($w['level'] == 4) {
                $wilayah[$w['id']] = array(
                    'id' => $w['id'],
                    'nama' => 'Desa ' . $w['nama']
                );
            }
        }

        foreach ($wilayah as $k => $w) {
            $kode = substr($w['id'], 0, 8);
            $wilayah[$k]['nama'] .= ' - Kecamatan ' . $kecamatan[$kode . '.0000'];
        }
        $data = [
            'dataHeader' => [
                'title' => (empty($id) ? 'Tambah' : 'Update') . ' Data Lansia',
                'extra_js' => [
                    'vendor/adminlte/plugins/moment/moment.min.js',
                    "vendor/adminlte/plugins/daterangepicker/daterangepicker.js",
                    "vendor/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
                    'vendor/adminlte/plugins/inputmask/jquery.inputmask.min.js',
                    'vendor/adminlte/plugins/select2/js/select2.full.min.js'

                ],
                'extra_css' => [
                    'vendor/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                    'vendor/adminlte/plugins/daterangepicker/daterangepicker.css',
                    'vendor/adminlte/plugins/select2/css/select2.min.css',
                    'vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'lansia'
            ],
            'contents' => [
                'lansia' => [
                    'view' => 'pages/tambah_lansia',
                    'data' => ['dataLansia' => $dataLansia, 'wil' => $wilayah, 'mode' => empty($id) ? 'baru' : 'edit']
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    public function kunjungan($lansia, $tahunTerpilih = null)
    {
        if (empty($tahunTerpilih)) {
            $tahunTerpilih = date('Y');
        }
        $dataLansia = $this->lansiaModel->get_pemeriksaan(null, $lansia, $tahunTerpilih);
        // echo json_encode($dataLansia);die;
        $session = session();
        $wilayahModel = new WilayahModel();
        $wilayah = $wilayahModel->findAll();
        $wilayah = array_combine(array_column($wilayah, 'id'), array_column($wilayah, 'nama'));

        $map = [
            'nama',
            'alamat',
            function ($rec) {
                $estimasi = $rec['estimasi_ttl'] == 1 ? '<span class="badge bg-info">Estimasi</span>' : '';
                return $rec['tanggal_lahir'] . $estimasi;
            },
            'nik',
        ];
        for ($i = 1; $i <= 12; $i++) {
            $map[] = function ($rec) use ($i, $tahunTerpilih, $lansia) {
                $bulan = $tahunTerpilih . '-' . ($i < 10 ? '0' . $i : $i) . '-01';
                $value = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['berat'] : null;
                $idKunjungan = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['id'] : null;
                $pemeriksa = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['nama_pemeriksa'] : sessiondata('login', 'nama_lengkap');

                $icon = '<i style="font-size: 12px;cursor:pointer" data-pemeriksa="' . $pemeriksa . '" data-kunjungan="' . $idKunjungan . '" data-bulan="' . $i . '" data-value="' . $value . '" data-tahun="' . $tahunTerpilih . '" data-lansia="' . $lansia . '" class="text-warning ml-2 edit-kunjungan-lansia fas fa-pencil-alt" aria-hidden="true"></i>';
                if (date('Y') == $tahunTerpilih && $i > date('m'))
                    $icon = null;

                if (!is_null($value)) {
                    $icon .= '<i style="font-size: 12px;cursor:pointer" data-kunjungan="' . $idKunjungan . '" class="text-danger ml-2 hapus-kunjungan-lansia fas fa-trash-alt" aria-hidden="true"></i>';
                }
                return ($value) . $icon;
            };
        }
        $data = [
            'dataHeader' => [
                'title' => 'Data Kunjungan Lansia',
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
            'dataFooter' => [
                'extra_js' => [
                    "js/pages/kunjungan_lansia.js"
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'lansia'
            ],
            'contents' => [
                'filter' => [
                    'view' => 'components/filter_tahun',
                    'data' => ['tahunTerpilih' => $tahunTerpilih, 'id' => $lansia, 'callbackUrl' => 'lansia/kunjungan/']
                ],
                'modal_tambah' => [
                    'view' => 'widgets/form_tambah_pemeriksaan_lansia',
                    'data' => ['tahun' => $tahunTerpilih, 'formid' => 'form-pemeriksaan-lansia']
                ],
                'lansia' => [
                    'view' => 'components/datatables',
                    'data' => [
                        // 'buttons' => [
                        //     [
                        //         'text' => 'Tambah Data',
                        //         'action' => load_script('pages/action_kunjungan_lansia', ['lansia' => $lansia, 'formid' => 'form-pemeriksaan-lansia'])
                        //     ]
                        // ],
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-lansia',
                        'header' => 'widgets/header_pemeriksaan_lansia',
                        'map' => $map,
                        'data' => $dataLansia
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    // Untuk keperluan pemeriksaan
    public function add_kunjungan()
    {
        $post = $this->request->getPost();
        $message = null;
        if (!c_isset($post, 'lansia') || empty($post['lansia']))
            $message = 'ID Lansia INVALID';

        $db = \Config\Database::connect();
        $date = waktu(strtotime(($post['tahun'] ?? $post['tahun_act']) . '-' . ($post['bulan'] ?? $post['bulan_act']) . '-01'), MYSQL_DATE_FORMAT);
        $kunjungan = $db->table('kunjungan_lansia')->where('lansia', $post['lansia'])->where('bulan', $date)->select('*')->get()->getResult();

        if (!empty($kunjungan))
            $message = 'Pemeriksaan untuk bulan ' . substr($date, 0, 7) . ' sudah dilakukan';

        if (empty($message)) {
            $db->table('kunjungan_lansia')->insert([
                'id' => random(8),
                'registrar' => sessiondata('login', 'username'),
                'dibuat' => waktu(),
                'bulan' => $date,
                'lansia' => $post['lansia'],
                'berat' => intval($post['berat']),
                'nama_pemeriksa' => $post['pemeriksa']
            ]);
            $message = 'Berhasil menambah data pemeriksaan Lansia';
        }
        return redirect()->to(base_url('lansia/kunjungan/' . $post['lansia']) . '/' . ($post['tahun'] ?? $post['tahun_act']))->with('response', $message);
    }
    public function update_kunjungan($kunjungan = null)
    {
    }
    public function set_kunjungan($kunjungan = null)
    {
        $post = $this->request->getPost();
        $message = null;
        if (!c_isset($post, 'lansia') || empty($post['lansia']))
            $message = 'ID Lansia INVALID';

        $db = \Config\Database::connect();
        $dataKunjungan = $db->table('kunjungan_lansia')->where('id', $kunjungan)->get()->getResult();

        if (empty($dataKunjungan))
            $message = 'Data kunjungan tidak ditemukan';

        if (empty($message)) {
            $db->table('kunjungan_lansia')->where('id', $kunjungan)->update([
                'berat' => intval($post['berat']),
                'nama_pemeriksa' => $post['pemeriksa']
            ]);
            $message = 'Berhasil merubah data pemeriksaan Lansia';
        }
        return redirect()->to(base_url('lansia/kunjungan/' . $post['lansia']) . '/' . $post['tahun_act'])->with('response', $message);
    }
    public function delete_kunjungan()
    {
        $post = $this->request->getPost();
        $session = session();
        $message = 'Data pemeriksaan berhasil dihapus';
        $berhasil = true;
        if (!isset($post['kunjungan'])) {
            $message = 'ID pemeriksaan invalid';
            $berhasil = false;
        }
        $db = \Config\Database::connect();
        $kunjungan = $db->table('kunjungan_lansia')->where('id', $post['kunjungan'])->get()->getResult();
        if (empty($kunjungan)) {
            $message = 'Data pemeriksaan tidak ditemukan';
            $berhasil = false;
        }

        if ($berhasil) {
            $db->table('kunjungan_lansia')->where('id', $post['kunjungan'])->delete();
            $session->setFlashdata(['response' => $message]);
        }
        return $this->response->setJSON(['message' => $message, 'type' => $berhasil ? 'success' : 'error']);
    }
}
