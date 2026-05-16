<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Entitas\MekanikModel;

class Mekanik extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MekanikModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_mekanik', $keyword);
        }

        return view('backend/master/mekanik/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave([
            'nama_mekanik' => $this->request->getPost('nama_mekanik')
        ]);
    }

    public function update($id)
    {
        return $this->handleUpdate($id, [
            'nama_mekanik' => $this->request->getPost('nama_mekanik')
        ]);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}