<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/login');
    }
    public function dashboard(){
        $data = [
            'dataHeader' => [
                'title' => 'Dashboard'
            ],
            'sidebarOpt' => [
                'activeMenu' => 'dashboard'
            ]
        ];
        return view('templates/adminlte', $data);
    }
}
