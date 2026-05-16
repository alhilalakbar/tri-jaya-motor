<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Kendaraan\MerkMotorModel;

class MerekMotor extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MerkMotorModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_merek_motor', $keyword);
        }

        return view('backend/master/merek_motor/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave([
            'nama_merek_motor' => $this->request->getPost('nama_merek_motor')
        ]);
    }

    public function update($id)
    {
        return $this->handleUpdate($id, [
            'nama_merek_motor' => $this->request->getPost('nama_merek_motor')
        ]);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}