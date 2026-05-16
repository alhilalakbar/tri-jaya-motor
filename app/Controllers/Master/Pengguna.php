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