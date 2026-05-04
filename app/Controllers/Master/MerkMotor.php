<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\MerkMotorModel;

class MerkMotor extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new MerkMotorModel();
    }

    public function index()
    {
        return view('master/merk_motor/index', ['data' => $this->model->findAll()]);
    }
    public function save()
    {
        $this->model->save(['nama_merk' => $this->request->getPost('nama_merk')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_merk' => $this->request->getPost('nama_merk')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}