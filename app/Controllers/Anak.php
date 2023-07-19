<?php

namespace App\Controllers;

use App\Models\AnakModel;
use App\Models\WilayahModel;

class Anak extends BaseController
{
    protected $anakModel;
    public function __construct()
    {
        $this->anakModel = new AnakModel();
    }
    function list($umur = null)
    {
        if (!empty($umur) && !in_array($umur, ['05', '611', '1223', '2459']))
            return view('errors/html/error_404', ['message' => 'Halaman tidak ditemukan']);
        $textUmur = null;
        switch ($umur) {
            case '05':
                $textUmur = ' Umur 0 - 5 Bulan';
                break;
            case '611':
                $textUmur = ' Umur 6 - 11 Bulan';
                break;
            case '1223':
                $textUmur = ' Umur 12 - 23 Bulan';
                break;
            case '2459':
                $textUmur = ' Umur 24 - 59 Bulan';
                break;
        }
        $dataAnak = reversemapping('anak', $this->anakModel->findByUmur($umur), [], [], true);
        $session = session();
        $wilayahModel = new WilayahModel();
        $wilayah = $wilayahModel->findAll();
        $wilayah = array_combine(array_column($wilayah, 'id'), array_column($wilayah, 'nama'));
        $data = [
            'dataHeader' => [
                'title' => 'Data Bayi/Balita' . ($textUmur ?? ''),
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
                    "js/pages/anak.js"
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'bayi' . $umur
            ],
            'contents' => [
                'anak' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'buttons' => [
                            [
                                'text' => 'Tambah Data',
                                'action' => 'function( e, dt, node, config ){location.href = basepath + "anak/daftar"}'
                            ]
                        ],
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-anak',
                        'header' => [
                            'No' => function ($data, $key) {
                                return $key + 1;
                            },
                            'Nama' => 'nama',
                            'L/P' => 'kelamin',
                            'BBL' => 'bbl',
                            'Ibu' => 'ibu',
                            'Ayah' => 'ayah',
                            'Tanggal Lahir' => function ($data) {
                                $badge = null;
                                if ($data['estimasi'] == 1) {
                                    $badge = '<span class="ml-2 badge bg-info badge-xs">Estimasi</span>';
                                }
                                return $data['ttl'] . $badge;
                            },
                            'Alamat' => function ($rec) use ($wilayah) {
                                $desa = $wilayah[$rec['alamat']];
                                $kecamatan = $wilayah[substr($rec['alamat'], 0, 8) . '.0000'];
                                return 'Desa ' . $desa . ', Kec. ' . $kecamatan;
                            },

                            'AKB' => 'akb',
                            'Action' => function ($data) {
                                return '<div style="margin:auto" class="row"><a href="' . base_url('anak/kunjungan/' . $data['id']) . '" class="btb btn-xs btn-info">Periksa</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('anak/update/' . $data['id']) . '" class="btb btn-xs btn-warning">Update</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('anak/delete/' . $data['id']) . '" class="btb btn-hapus-anak btn-xs btn-danger">Delete</a></div>';
                            }
                        ],
                        'data' => $dataAnak
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }

    function add()
    {
        return $this->forms();
    }
    function update($id)
    {
        return $this->forms($id);
    }
    function save()
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
                $umur = intval($post['umur']) * (60 * 60 * 24 * 30);
                $ttl = waktu($hariIni - $umur, MYSQL_DATE_FORMAT);
                $estimasi = '1';
            }
            $def = array(
                'ttl' => $ttl
            );
            $data = fieldmapping('anak', $post, $def);
            $data['id'] = random(8);
            $data['dibuat'] = waktu();
            $data['estimasi_ttl'] = $estimasi;
            $data['registrar'] = sessiondata('login', 'username');
            try {
                $this->anakModel->insert($data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect()->to(base_url(empty($message) ? 'anak/list' : 'anak/daftar'))->with('response', $message)->with('anakData', $post);
    }
    function set()
    {
        $post = $this->request->getPost();
        $message = null;
        $ttl = waktu(null, MYSQL_DATE_FORMAT);
        $id = $post['id'];

        if (empty($id))
            $message = 'Gagal, Data tidak ditemukan';
        if ($post['ingat_ttl'] == 0 && !is_numeric($post['umur'])) {
            $message = "Umur harus angka";
        } else {
            $estimasi = '0';
            if ($post['ingat_ttl'] == 0) {
                $hariIni = time();
                $umur = intval($post['umur']) * (60 * 60 * 24 * 30);
                $ttl = waktu($hariIni - $umur, MYSQL_DATE_FORMAT);
                $estimasi = '1';
            }
            $def = array(
                'ttl' => $ttl
            );
            $data = fieldmapping('anak', $post, $def);
            $data['estimasi_ttl'] = $estimasi;
            try {
                $this->anakModel->update($id, $data);
            } catch (\Throwable $th) {
                $message = htmlspecialchars($th->getMessage());
            }
        }
        return redirect()->to(base_url(empty($message) ? 'anak/list' : 'anak/update/' . $id))->with('response', $message)->with('anakData', $post);
    }
    function delete($id)
    {
        $dataAnak = $this->anakModel->find($id);
        if (empty($dataAnak))
            return redirect()->to(base_url('anak/list'))->with('response', 'Gagal hapus data, ID tidak dikenali');

        $this->anakModel->delete($id);
        return redirect()->to(base_url('anak/list'))->with('response', 'Berhasil hapus data anak');
    }

    function forms($id = null)
    {
        $dataAnak = [];
        if (!empty($id)) {
            $dataAnak = $this->anakModel->find($id);
            if (empty($dataAnak))
                return view('errors/html/error_404', ['code' => '404', 'message' => "Data dengan ID $id tidak ditemukan"]);
            $dataAnak = reversemapping('anak', $dataAnak);
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
                'title' => (empty($id) ? 'Tambah' : 'Update') . ' Data Bayi/Balita',
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
                'activeMenu' => 'bayi'
            ],
            'contents' => [
                'anak' => [
                    'view' => 'pages/tambah_anak',
                    'data' => ['dataAnak' => $dataAnak, 'wil' => $wilayah, 'mode' => empty($id) ? 'baru' : 'edit']
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }


    function kunjungan($anak, $tahun = null)
    {
        if (empty($tahun))
            $tahun = date('Y');

        if (empty($tahunTerpilih)) {
            $tahunTerpilih = date('Y');
        }
        $dataAnak = $this->anakModel->get_pemeriksaan(null, $anak, $tahunTerpilih);
        // echo json_encode($dataAnak);die;
        $session = session();
        $wilayahModel = new WilayahModel();
        $wilayah = $wilayahModel->findAll();
        $wilayah = array_combine(array_column($wilayah, 'id'), array_column($wilayah, 'nama'));

        $map = [
            'nama',
            'alamat',
            'tanggal_lahir',
            'ibu'
        ];
        for ($i = 1; $i <= 12; $i++) {
            $map[] = function ($rec) use ($i, $tahunTerpilih, $anak) {
                $bulan = $tahunTerpilih . '-' . ($i < 10 ? '0' . $i : $i) . '-01';
                $berat = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['berat'] : '-';
                $tinggi = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['tinggi'] : '-';
                $idKunjungan = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['id'] : null;
                $pemeriksa = isset($rec['pemeriksaan'][$bulan]) ? $rec['pemeriksaan'][$bulan]['nama_pemeriksa'] : sessiondata('login', 'nama_lengkap');
                $value = $berat . '/' . $tinggi;
                $icon = '<i style="font-size: 12px;cursor:pointer" data-pemeriksa="'.$pemeriksa.'" data-kunjungan="' . $idKunjungan . '" data-bulan="' . $i . '" data-value="' . ($value == '-/-' ? null : $value) . '" data-tahun="' . $tahunTerpilih . '" data-anak="' . $anak . '" class="text-warning ml-2 edit-kunjungan-anak fas fa-pencil-alt" aria-hidden="true"></i>';
                if ($value != '-/-') {
                    $icon .= '<i style="font-size: 12px;cursor:pointer" data-kunjungan="' . $idKunjungan . '" class="text-danger ml-2 hapus-kunjungan-anak fas fa-trash-alt" aria-hidden="true"></i>';
                }
                return date('Y') == $tahunTerpilih && $i > date('m') ? null : ($value . $icon);
            };
        }
        $data = [
            'dataHeader' => [
                'title' => 'Data Kunjungan bayi/balita',
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
                    "js/pages/anak.js"
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => 'anak'
            ],
            'contents' => [
                'filter' => [
                    'view' => 'components/filter_tahun',
                    'data' => ['tahunTerpilih' => $tahunTerpilih, 'id' => $anak, 'callbackUrl' => 'anak/kunjungan/']
                ],
                'modal_tambah' => [
                    'view' => 'widgets/form_tambah_pemeriksaan_anak',
                    'data' => ['tahun' => $tahunTerpilih, 'formid' => 'form-pemeriksaan-anak']
                ],
                'anak' => [
                    'view' => 'components/datatables',
                    'data' => [
                        // 'buttons' => [
                        //     [
                        //         'text' => 'Tambah Data',
                        //         'action' => load_script('pages/action_kunjungan_anak', ['anak' => $anak, 'formid' => 'form-pemeriksaan-anak'])
                        //     ]
                        // ],
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-anak',
                        'header' => 'widgets/header_pemeriksaan_anak',
                        'map' => $map,
                        'data' => $dataAnak
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
        if(!c_isset($post, 'anak') || empty($post['anak']))
            $message = 'ID Anak INVALID';

        $db = \Config\Database::connect();
        $date = waktu(strtotime(($post['tahun'] ?? $post['tahun_act']) . '-' . ($post['bulan'] ?? $post['bulan_act']) . '-01'), MYSQL_DATE_FORMAT);
        $kunjungan = $db->table('kunjungan_anak')->where('anak', $post['anak'])->where('bulan', $date)->select('*')->get()->getResult();
        
        if(!empty($kunjungan))
            $message = 'Pemeriksaan untuk bulan ' . substr($date, 0, 7) . ' sudah dilakukan';

        if(empty($message)){
            $db->table('kunjungan_anak')->insert([
                'id' => random(8),
                'registrar' => sessiondata('login', 'username'),
                'dibuat' => waktu(),
                'bulan' => $date,
                'anak' => $post['anak'],
                'berat' => intval($post['berat']),
                'nama_pemeriksa' => $post['pemeriksa'],
                'tinggi' => intval($post['tinggi'])
            ]);
            $message = 'Berhasil menambah data pemeriksaan Anak';
        }
        return redirect()->to(base_url('anak/kunjungan/' . $post['anak']) . '/' . ($post['tahun'] ?? $post['tahun_act']))->with('response', $message);
    }
    public function update_kunjungan($kunjungan = null)
    {
    }
    public function set_kunjungan($kunjungan = null)
    {
        $post = $this->request->getPost();
        $message = null;
        if(!c_isset($post, 'anak') || empty($post['anak']))
            $message = 'ID Anak INVALID';

        $db = \Config\Database::connect();
        $dataKunjungan = $db->table('kunjungan_anak')->where('id', $kunjungan)->get()->getResult();
        
        if(empty($dataKunjungan))
            $message = 'Data kunjungan tidak ditemukan';
        
        if(empty($message)){
            $db->table('kunjungan_anak')->where('id', $kunjungan)->update([
                'berat' => intval($post['berat']),
                'tinggi' => intval($post['tinggi']),
                'nama_pemeriksa' => $post['pemeriksa']
            ]);
            $message = 'Berhasil merubah data pemeriksaan Anak';
        }
        return redirect()->to(base_url('anak/kunjungan/' . $post['anak']) . '/' . $post['tahun_act'])->with('response', $message);
    }
    public function delete_kunjungan()
    {
        $post = $this->request->getPost();
        $session = session();
        $message = 'Data pemeriksaan berhasil dihapus';
        $berhasil = true;
        if(!isset($post['kunjungan'])){
           $message = 'ID pemeriksaan invalid'; 
           $berhasil = false;
        }
        $db = \Config\Database::connect();
        $kunjungan = $db->table('kunjungan_anak')->where('id', $post['kunjungan'])->get()->getResult();
        if(empty($kunjungan)){
           $message = 'Data pemeriksaan tidak ditemukan';
           $berhasil = false;
        }

        if($berhasil){
            $db->table('kunjungan_anak')->where('id', $post['kunjungan'])->delete();
            $session->setFlashdata(['response' => $message]);
        }
        return $this->response->setJSON(['message' => $message, 'type' => $berhasil ? 'success' : 'error']);
    }
}
