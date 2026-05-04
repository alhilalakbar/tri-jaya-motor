<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\TipeMotorModel;
use App\Models\Master\Kendaraan\MerkMotorModel;

class TipeMotor extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new TipeMotorModel();
    }

    public function index()
    {
        $merk = new MerkMotorModel();
        $data = [
            'tipe' => $this->model->select('tipe_motor.*, merk_motor.nama_merk')->join('merk_motor', 'merk_motor.id_merek_motor = tipe_motor.id_merek_motor')->findAll(),
            'merk' => $merk->findAll()
        ];
        return view('master/tipe_motor/index', $data);
    }
    public function save()
    {
        $this->model->save(['id_merek_motor' => $this->request->getPost('id_merek_motor'), 'nama_tipe' => $this->request->getPost('nama_tipe'), 'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['id_merek_motor' => $this->request->getPost('id_merek_motor'), 'nama_tipe' => $this->request->getPost('nama_tipe'), 'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}