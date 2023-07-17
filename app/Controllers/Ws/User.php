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
        if (is_login())
            return response("Anda sudah login", 403);

        $username = $this->request->getPost('user');
        $password = $this->request->getPost('password');
        list($success, $message) = $this->userModel->login($username, $password);

        if (!$success)
            return redirect('/')->with('loginMessage', $message)->with('loginData', ['username' => $username, 'password' => $password]);

        return redirect('dashboard')->with('loginMessage', 'Selamat Datang ' . $username);
    }
    function logout()
    {
        if (!is_login())
            return response("Anda belum login", 403);

        $session = session();
        $session->remove('login');
        return redirect('/')->with('loginMessage', 'Anda baru saja logout');
    }

    function getByUsername($username)
    {
        $data = $this->userModel->find($username);
        return $this->response->setJSON($data);
    }

    function send_token()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->find();

        if (empty($user))
            return redirect()->to(base_url('forgot/password'))->with('response', 'Akun dengan email <b>' . $email . '</b> Tidak ditemukan');

        $token = random(20);
        $expired = waktu(time() + (60 * 30));

        $db = \Config\Database::connect();
        $db->table('tokens')->insert(['token' => $token, 'email' => $email, 'expired' => $expired]);

        $emailSender = \Config\Services::email();

        $emailSender->setFrom('', 'Sistem Informasi Pelayanan Posyandu');
        $emailSender->setTo($email);
        $emailSender->setCC('another@another-example.com');
        $emailSender->setBCC('them@their-example.com');

        $emailSender->setSubject('Reset Password');
        $emailSender->setMessage('<p>Berikut ini adalah Token untuk mereset password anda: <b>' . $token . '</b></p> <br><p>Atau anda juga bisa reset password anda dengan klik link berikut: <br><a href="' . base_url('reset/password/' . $token) . '">'. base_url('reset/password/' . $token) .'</a></p> <br> <p>Untuk diperhatikan, Token akan kadaluarsa dalam <b>30 Menit </b></p>');

        $emailSender->send();

        return redirect()->to(base_url('forgot/password'))->with('response', 'Kami telah mengirimkan email ke alamat <b>' . $email . '</b> untuk mereset password anda');
    }

    function reset_password()
    {
        $post = $this->request->getPost();
        if ($post['password'] != $post['repassword'])
            return redirect()->to(base_url('reset/password/' . $post['token']))->with('response', 'Password yang dimasukkan tidak sama');

        $db = \Config\Database::connect();
        $token = $db->table('tokens')->where('token', $post['token'])->get()->getRow();

        if (empty($token))
            return redirect()->to(base_url('reset/password/' . $post['token']))->with('response', 'Token Invalid');
        elseif (!empty($token->used))
            return redirect()->to(base_url('reset/password/' . $post['token']))->with('response', 'Token Sudah Digunakan');
        elseif (time() > strtotime($token->expired))
            return redirect()->to(base_url('reset/password/' . $post['token']))->with('response', 'Token Sudah Kadaluarsa, silahkan kirim email lagi melalui <a href="' . base_url("forgot/password") . '">Link berikut </a>');

        $db->table('tokens')->where('token', $post['token'])->update(['used' => waktu()]);
        $db->table('users')->where('email', $token->email)->update(['password' => password_hash($post['password'], PASSWORD_DEFAULT)]);

        return redirect()->to(base_url())->with('loginMessage', 'Berhasil Mengganti Password')->with('loginData', ['username' => $token->email, 'password' => $post['password']]);
    }
}
