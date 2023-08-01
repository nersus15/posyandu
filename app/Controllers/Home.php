<?php

namespace App\Controllers;

use App\Models\BumilModel;
use CodeIgniter\Files\File;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/login');
    }
    public function dashboard()
    {
        $dataDashboard = [];
        $db = \Config\Database::connect();
        $bumilModel = new BumilModel();
        $tahunIni = date('Y');
        $bulanIni = waktu(null, MYSQL_DATE_FORMAT);
        if (is_login('kader')) {
            $dataBumil =  $bumilModel->where('registrar', sessiondata('login', 'username'))->findAll();
            $dataPemeriksaan = $db->table('kunjungan_bumil')->where('registrar', sessiondata('login', 'username'))->get()->getResult();
            $dataAnak = $db->table('anak')->where('registrar', sessiondata('login', 'username'))->get()->getNumRows();
            $periksaAnak = $db->table('kunjungan_anak')->where('registrar', sessiondata('login', 'username'))->get()->getNumRows();
            $dataLansia= $db->table('lansia')->where('registrar', sessiondata('login', 'username'))->get()->getNumRows();
            $periksaLansia = $db->table('kunjungan_lansia')->where('registrar', sessiondata('login', 'username'))->get()->getNumRows();
            
            
            $dataDashboard = [
                'jmlbumil' => count($dataBumil),
                'periksa' => count($dataPemeriksaan),
                'jml_bayi' => $dataAnak,
                'periksa_anak' => $periksaAnak,
                'jml_lansia' => $dataLansia,
                'periksa_lansia' => $periksaLansia
            ];
        } elseif (is_login('bidan')) {
            $dataBumil =  $bumilModel->getBYWilker(sessiondata('login', 'wilayah_kerja'));
            $dataPemeriksaan = $db->table('kunjungan_bumil')->where('registrar', sessiondata('login', 'username'))->get()->getResult();
            $dataDashboard = [
                'jmlbumil' => count($dataBumil),
                'periksa' => count($dataPemeriksaan)
            ];
        } elseif (is_login('admin')) {
            $tmp = $db->table('users')->select('role, COUNT(*) jml')->groupBy('role')->get()->getResult();
            $dataUser = [
                'admin' => 0,
                'bidan' => 0,
                'kader' => 0
            ];
            foreach($tmp as $v){
                $dataUser[$v->role] += $v->jml;
            }
            $dataDashboard = [
                'bidan' => $dataUser['bidan'],
                'kader' => $dataUser['kader'],
            ];
        }

        $data = [
            'dataHeader' => [
                'title' => 'Dashboard'
            ],
            'sidebarOpt' => [
                'activeMenu' => 'dashboard'
            ],
            'contents' => [
                'cards' => [
                    'view' => 'pages/dashboard/' . sessiondata('login', 'role'),
                    'data' => $dataDashboard
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
    function profile()
    {
        $data = [
            'dataHeader' => [
                'title' => sessiondata('login', 'nama_lengkap'),
                'extra_js' => [
                    'vendor/adminlte/plugins/select2/js/select2.js'
                ],
                'extra_css' => [
                    'css/profile.css',
                    'vendor/adminlte/plugins/select2/css/select2.css',
                    'vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.css'
                ]
            ],
            'contents' => [
                'profile' => [
                    'view' => 'pages/profile',
                    'data' => sessiondata()
                ]
                ],
            'sidebarOpt' => [
                'activeMenu' => ''
            ]
        ];
        return view('templates/adminlte', $data);
    }
    function update_profile()
    {
        $post = $this->request->getPost();
        $userModel = new \App\Models\User();

        $username = $post['username'];
        $password = $post['password'];

        unset($post['username'], $post['password']);
        if (!empty($password)) {
            $post['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $post['alamat'] = empty($post['desa']) ? $post['kecamatan'] : $post['desa'];
        $post['wilayah_kerja'] = empty($post['desa_kerja']) ? $post['kecamatan_kerja'] : $post['desa_kerja'];
        unset($post['kecamatan'], $post['desa']);
        $files = $this->request->getFiles();
        try {
            if (isset($files['photo']) && $_FILES['photo']['size'] > 0) {
                $img = $this->request->getFile('photo');
                $nama = random(8) . '.' . getExt($img->getName(), true);
                if (!$img->hasMoved()) {
                    $filepath = $img->store(ASSETS_PATH . 'img/profile/', $nama);
                    new File($filepath);
                }
                $post['photo'] = $nama;
            }else{
                $post['photo'] = sessiondata('login', 'photo');
            }
            $userModel->update($username, $post);
        } catch (\Throwable $th) {
            return redirect()->to('profile')->with('response', $th->getMessage());
        }

        $session = session();
        $session->set('login', $post + ['username' => $username, 'role' => sessiondata('login', 'role')]);
        return redirect()->to('profile')->with('response', 'Berhasil memperbarui profile');
    }
}
