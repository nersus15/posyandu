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
        if(is_login())
            return response("Anda sudah login", 403);

        $username = $this->request->getPost('user');
        $password = $this->request->getPost('password');
        list($success, $message) = $this->userModel->login($username, $password);
        
        if(!$success)
            return redirect('/')->with('loginMessage', $message)->with('loginData', ['username' => $username, 'password' => $password]);
        
        return redirect('dashboard')->with('loginMessage', 'Selamat Datang ' . $username);
    }
    function logout(){
        if(!is_login())
            return response("Anda belum login", 403);
        
        $session = session();
        $session->remove('login');
        return redirect('/')->with('loginMessage', 'Anda baru saja logout');
    }

    function getByUsername($username){
        $data = $this->userModel->find($username);
        return $this->response->setJSON($data);
    }
}
