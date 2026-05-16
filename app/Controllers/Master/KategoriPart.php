<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Part\KategoriPartModel;

class KategoriPart extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KategoriPartModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_kategori', $keyword);
        }

        return view('backend/master/kategori_part/index', [
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