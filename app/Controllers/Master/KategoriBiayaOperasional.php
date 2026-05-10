<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\KategoriBiayaOperasionalModel;

class KategoriBiayaOperasional extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KategoriBiayaOperasionalModel();
    }

    public function index()
    {
        $data = [

            'title' => 'Kategori Biaya Operasional',

            'data' => $this->model
                ->orderBy('id_kategori_biaya', 'DESC')
                ->findAll(),
        ];

        return view(
            'backend/master/kategori_biaya_operasional/index',
            $data
        );
    }

    public function save()
    {
        $data = [

            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        $this->model->save($data);

        return redirect()->to(
            base_url('backend/master/kategori_biaya_operasional')
        );
    }

    public function update($id)
    {
        $data = [

            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        $this->model->update($id, $data);

        return redirect()->to(
            base_url('backend/master/kategori_biaya_operasional')
        );
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect()->to(
            base_url('backend/master/kategori_biaya_operasional')
        );
    }
}