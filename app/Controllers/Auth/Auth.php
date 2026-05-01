<?php

namespace App\Controllers;

use App\Models\Auth\UserModel;

class Auth extends BaseController
{
    public function login() {
        return view('auth/login', ['title' => 'Login System']);
    }

    public function attemptLogin() {
        $userModel = new UserModel();
        $nama     = $this->request->getPost('nama_pengguna');
        $password = $this->request->getPost('kata_sandi');

        $user = $userModel->where('nama_pengguna', $nama)->first();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            session()->set([
                'id_user' => $user['id_pengguna'],
                'nama'    => $user['nama_pengguna'],
                'peran'   => $user['peran'],
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Nama pengguna atau kata sandi salah.');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
