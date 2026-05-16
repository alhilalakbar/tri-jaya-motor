<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Entitas\PelangganModel;

class Pelanggan extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PelangganModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->groupStart()
                ->like('nama_pelanggan', $keyword)
                ->orLike('nomor_hp', $keyword)
                ->groupEnd();
        }

        return view('backend/master/pelanggan/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave($this->request->getPost());
    }

    public function update($id)
    {
        return $this->handleUpdate($id, $this->request->getPost());
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}