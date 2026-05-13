<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\MerkMotorModel;

class MerekMotor extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new MerkMotorModel();
    }

    public function index()
    {
        return view('backend/master/merk_motor/index', ['data' => $this->model->findAll()]);
    }
    public function save()
    {
        $this->model->save(['nama_merek_motor' => $this->request->getPost('nama_merek_motor')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_merek_motor' => $this->request->getPost('nama_merek_motor')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}