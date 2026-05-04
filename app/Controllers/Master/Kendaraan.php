<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\KendaraanModel;
use App\Models\Master\Entitas\PelangganModel;
use App\Models\Master\Kendaraan\TipeMotorModel;

class Kendaraan extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new KendaraanModel();
    }

    public function index()
    {
        $pel = new PelangganModel();
        $tipe = new TipeMotorModel();
        $data = [
            'kendaraan' => $this->model->select('kendaraan.*, pelanggan.nama_pelanggan, tipe_motor.nama_tipe')
                ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
                ->join('tipe_motor', 'tipe_motor.id_tipe_motor = kendaraan.id_tipe_motor')->findAll(),
            'pelanggan' => $pel->findAll(),
            'tipe' => $tipe->findAll()
        ];
        return view('master/kendaraan/index', $data);
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