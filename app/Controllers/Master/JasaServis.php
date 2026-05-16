<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Layanan\JasaServisModel;

class JasaServis extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new JasaServisModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_jasa', $keyword);
        }

        return view('backend/master/jasa_servis/index', [
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