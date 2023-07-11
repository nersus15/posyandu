<?php

namespace App\Controllers;

use App\Models\BumilModel;

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
                'title' => sessiondata('login', 'nama_lengkap')
            ],
            'sidebarOpt' => [
                'activeMenu' => ''
            ]
        ];
        return view('templates/adminlte', $data);
    }
}
