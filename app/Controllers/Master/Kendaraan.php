<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\KendaraanModel;
use App\Models\Master\PelangganModel;
use App\Models\Master\TipeMotorModel;

class Kendaraan extends BaseController
{
    public function index() {
        $kdModel = new KendaraanModel();
        return view('master/kendaraan/index', [
            'title' => 'Data Kendaraan',
            'kendaraan' => $kdModel->select('kendaraan.*, pelanggan.nama_pelanggan, tipe_motor.nama_tipe')
                                   ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan') 
                                   ->join('tipe_motor', 'tipe_motor.id_tipe_motor = kendaraan.id_tipe_motor') 
                                   ->findAll(),
            'pelanggan' => (new PelangganModel())->findAll(), 
            'tipe' => (new TipeMotorModel())->findAll() 
        ]);
    }

    public function store() {
        (new KendaraanModel())->save([
            'id_pelanggan' => $this->request->getPost('id_pelanggan'), 
            'id_tipe_motor' => $this->request->getPost('id_tipe_motor'), 
            'nomor_plat' => $this->request->getPost('nomor_plat') 
        ]);
        return redirect()->to('/kendaraan');
    }

    public function edit(int $id) {
        $kdModel = new KendaraanModel();
        return view('master/kendaraan/edit', [
            'title' => 'Edit Kendaraan',
            'kendaraan' => $kdModel->find($id), 
            'pelanggan' => (new PelangganModel())->findAll(), 
            'tipe' => (new TipeMotorModel())->findAll() 
        ]);
    }

    public function update(int $id) {
        (new KendaraanModel())->update($id, [
            'id_pelanggan' => $this->request->getPost('id_pelanggan'), 
            'id_tipe_motor' => $this->request->getPost('id_tipe_motor'), 
            'nomor_plat' => $this->request->getPost('nomor_plat') 
        ]);
        return redirect()->to('/kendaraan');
    }

    public function delete(int $id) {
        (new KendaraanModel())->delete($id); 
        return redirect()->to('/kendaraan');
    }
}