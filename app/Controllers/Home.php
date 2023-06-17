<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/login');
    }
    public function dashboard(){
        return view('templates/adminlte');
    }
}
