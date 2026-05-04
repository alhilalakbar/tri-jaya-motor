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
        return view('master/pelanggan/index', ['data' => $this->model->findAll()]);
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