<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Entitas\PemasokModel;

class Pemasok extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PemasokModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->groupStart()
                ->like('nama_pemasok', $keyword)
                ->orLike('nomor_hp_pemasok', $keyword)
                ->orLike('alamat_pemasok', $keyword)
                ->groupEnd();
        }

        return view('backend/master/pemasok/index', [
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