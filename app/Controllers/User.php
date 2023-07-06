<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User as ModelsUser;
use App\Models\WilayahModel;

class User extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new ModelsUser();
    }
    public function index()
    {
        //
    }
    function list($role)
    {
        $dataUser = $this->userModel->where('role', $role)->findAll();
        $dataUser = reversemapping('user', $dataUser, [], [], true);
        $session = session();
        $wilayahModel = new WilayahModel();
        $wilayah = $wilayahModel->findAll();
        $tmp = $wilayah;
        $wilayah = array_combine(array_column($wilayah, 'id'), array_column($wilayah, 'nama'));
      
        $wilayahLengkap = [];
        $kecamatan = array_filter($tmp, function ($arr) {
            return $arr['level'] == 3;
        });
        $wilayahKec = $kecamatan;

        $kecamatan = array_combine(array_column($kecamatan, 'id'), array_column($kecamatan, 'nama'));
        foreach ($tmp as $w) {
            if ($w['level'] == 4) {
                $wilayahLengkap[$w['id']] = array(
                    'id' => $w['id'],
                    'nama' => 'Desa ' . $w['nama']
                );
            }
        }

        foreach ($wilayahLengkap as $k => $w) {
            $kode = substr($w['id'], 0, 8);
            $wilayahLengkap[$k]['nama'] .= ' - Kecamatan ' . $kecamatan[$kode . '.0000'];
        }

        $formid = 'form-user';
        $data = [
            'dataHeader' => [
                'title' => 'Data ' . ucfirst($role),
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
                    'vendor/adminlte/plugins/select2/js/select2.full.min.js'
                ],
                'extra_css' => [
                    'vendor/adminlte/plugins/select2/css/select2.min.css',
                    'vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'
                ]
            ],
            'dataFooter' => [
                'extra_js' => [
                    'js/pages/user.js'
                ]
            ],
            'sidebarOpt' => [
                'activeMenu' => $role
            ],
            'contents' => [
                'form_user' => [
                    'view' => 'widgets/form-tambah-user',
                    'data' => [
                        'formid' => $formid,
                        'role' => $role,
                        'wilLengkap' => $wilayahLengkap, 
                        'wil' => $role == 'kader' ? $wilayahLengkap : $wilayahKec
                    ]
                ],
                'user' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'buttons' => [
                            [
                                'text' => 'Tambah ' . ucfirst($role),
                                'action' => load_script('pages/action-add-user', ['role' => $role, 'formid' => $formid])
                            ]
                        ],
                        'desc' => $session->getFlashdata('response'),
                        'dtid' => 'dt-user',
                        'header' => [
                            'No' => function ($data, $key) {
                                return $key + 1;
                            },
                            'Tgl Didaftarkan' => 'dibuat',
                            'Username' => 'username',
                            'Nama' => 'nama',
                            'Email' => 'email',
                            'No. Hp' => 'hp',
                            'Alamat' => function ($rec) use ($wilayah) {
                                if(empty($rec['alamat'])) return null;
                                $desa = $wilayah[$rec['alamat']];
                                $kecamatan = $wilayah[substr($rec['alamat'], 0, 8) . '.0000'];
                                return 'Desa ' . $desa . ', Kec. ' . $kecamatan;
                            },
                            'Puskesmas' => 'faskes',
                            'Wilayah Kerja' => function ($rec) use ($wilayah) {
                                if(empty($rec['wilker'])) return null;
                                $desa = $wilayah[$rec['wilker']];
                                $kecamatan = $wilayah[substr($rec['wilker'], 0, 8) . '.0000'];

                                $levelWilayah = level_wilayah($rec['wilker']);
                                $text = $levelWilayah == 3 ? 'Kec. ' . $kecamatan : 'Desa ' . $desa . ', Kec. ' . $kecamatan;
                                return $text;
                            },
                            'Action' => function ($data) use($formid, $role) {
                                return '<div style="margin:auto" class="row mt-2"><a href="#" data-formid="'.$formid.'" data-username="'. $data['username'] .'" class="btb btn-update-user btn-xs btn-warning">Update</a></div><div style="margin:auto" class="row mt-2"><a href="' . base_url('user/delete/') . '" data-username="'. $data['username'] .'" data-role="'. $role .'" class="btb btn-hapus-user btn-xs btn-danger">Delete</a></div>';
                            }
                        ],
                        'data' => $dataUser
                    ]
                ]
            ]
        ];
        return view('templates/adminlte', $data);
    }
    function kader()
    {
        return $this->list('kader');
    }
    function bidan()
    {
        return $this->list('bidan');
    }

    function save(){
        $post = $this->request->getPost();
        $data= fieldmapping('user', $post);
        $message = 'Berhasil menambah data ' . $post['username'];
        $data['dibuat'] = waktu();
        $data['registrar'] = sessiondata('login', 'username');
        $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

        $oldUser = $this->userModel->where('email', $data['email'])->orWhere('hp', $data['hp'])->findAll();
        if(!empty($oldUser)){
            return redirect()->to(base_url('/' . $data['role']))->with('response', 'Email atau No.Hp sudah terdaftar, silahkan gunakan yang lain');
        }

        try {
            $this->userModel->insert($data);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }
        
        return redirect()->to(base_url('/' . $data['role']))->with('response', $message);
    }
    function set(){
        $post = $this->request->getPost();
        $message = 'Berhasil memperbarui data ' . $post['username'];
        $data= fieldmapping('user', $post);
        try {
            $this->userModel->update($data['username'], $data);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }
        
        return redirect()->to(base_url('/' . $data['role']))->with('response', $message);
    }
    function delete($username, $role){
        $data = $this->userModel->find($username);
        if(empty($data))
            return redirect()->to(base_url($role))->with('response', 'Data ' . $role . ' Tidak ditemukan');

        $this->userModel->delete($username);
        return redirect()->to(base_url($role))->with('response', 'Data ' . $role . ' ' . $username . ' Telah dihapus');
    }
}
