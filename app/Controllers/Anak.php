<?php

namespace App\Controllers;

class Anak extends BaseController
{
    function list($umur = null)
    {  
        if(!in_array($umur, ['05', '611', '1223', '2459']))
            return view('errors/html/error_404', ['message' => 'Halaman tidak ditemukan']);

        $data = [
            'sidebarOpt' => [
                'activeMenu' => 'bayi' . $umur
            ]
        ];
        return view('templates/adminlte', $data);
    }
}
