<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\KategoriBiayaOperasionalModel;

class KategoriBiayaOperasional extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KategoriBiayaOperasionalModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model->orderBy('id_kategori_biaya', 'DESC');

        if ($keyword) {
            $builder->like('nama_kategori', $keyword);
        }

        return view('backend/master/kategori_biaya_operasional/index', [
            'title' => 'Kategori Biaya Operasional',
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
    }

    public function update($id)
    {
        return $this->handleUpdate($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}