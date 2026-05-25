<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Entitas\PenggunaModel;

class Pengguna extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PenggunaModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->groupStart()
                ->like('nama_pengguna', $keyword)
                ->orLike('peran', $keyword)
                ->groupEnd();
        }

        return view('backend/master/pengguna/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function ubahPassword()
    {
        return view('backend/akun/ubah_password');
    }

    public function prosesUbahPassword()
    {
        $idPengguna = session()->get('id_pengguna');

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasiPassword = $this->request->getPost('konfirmasi_password');

        $user = $this->model->find($idPengguna);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        if (!password_verify($passwordLama, $user['kata_sandi'])) {
            return redirect()->back()->withInput()->with('error', 'Password lama salah.');
        }

        if ($passwordBaru !== $konfirmasiPassword) {
            return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
        }

        if (password_verify($passwordBaru, $user['kata_sandi'])) {
            return redirect()->back()->withInput()->with('error', 'Password baru harus berbeda dari password lama.');
        }

        $this->model->update($idPengguna, [
            'kata_sandi' => password_hash($passwordBaru, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    public function save()
    {
        $data = $this->request->getPost();

        $data['kata_sandi'] = password_hash(
            $data['kata_sandi'],
            PASSWORD_DEFAULT
        );

        return $this->handleSave($data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if (!empty($data['kata_sandi'])) {
            $data['kata_sandi'] = password_hash(
                $data['kata_sandi'],
                PASSWORD_DEFAULT
            );
        } else {
            unset($data['kata_sandi']);
        }

        return $this->handleUpdate($id, $data);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}