<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Part\MerekPartModel;

class MerekPart extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MerekPartModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_merek_part', $keyword);
        }

        return view('backend/master/merek_part/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave([
            'nama_merek_part' => $this->request->getPost('nama_merek_part')
        ]);
    }

    public function update($id)
    {
        return $this->handleUpdate($id, [
            'nama_merek_part' => $this->request->getPost('nama_merek_part')
        ]);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}