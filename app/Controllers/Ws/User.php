<?php

namespace App\Controllers\Ws;

use App\Controllers\BaseController;
use App\Models\User as ModelsUser;


class User extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new ModelsUser();
    }
    function login()
    {
        $username = $this->request->getPost('user');
        $password = $this->request->getPost('password');
        list($success, $message) = $this->userModel->login($username, $password);
        
        if(!$success)
            return redirect('/')->with('loginMessage', $message)->with('loginData', ['username' => $username, 'password' => $password]);
        
        return redirect('dashboard')->with('loginMessage', 'Selamat Datang ' . $username);
    }
}
