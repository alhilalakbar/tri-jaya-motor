<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Entitas\PelangganModel;

class Pelanggan extends BaseController
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
        $this->model->save($this->request->getPost());
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, $this->request->getPost());
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}