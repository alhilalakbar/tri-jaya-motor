<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Master\Entitas\PenggunaModel; 

class Auth extends BaseController
{

    public function index()
    {

        return view('auth/login');
    }

    public function login()
    {
        $model = new PenggunaModel();
        $username = $this->request->getPost('nama_pengguna'); 
        $password = $this->request->getPost('kata_sandi');

        $user = $model->where('nama_pengguna', $username)->first(); 

        if ($user) {
            if (password_verify($password, $user['kata_sandi'])) { 
                $sessionData = [
                    'id_pengguna' => $user['id_pengguna'], 
                    'nama_pengguna' => $user['nama_pengguna'], 
                    'peran' => $user['peran'], 
                    'isLoggedIn' => true
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Kata sandi salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}