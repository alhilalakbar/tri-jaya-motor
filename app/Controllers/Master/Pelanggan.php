<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\PelangganModel;

class Pelanggan extends BaseController
{
    protected PelangganModel $pelangganModel;

    public function __construct() {
        $this->pelangganModel = new PelangganModel();
    }

    public function index() {
        return view('master/pelanggan/index', [
            'title' => 'Data Pelanggan',
            'pelanggan' => $this->pelangganModel->findAll() 
        ]);
    }

    public function store() {
        $this->pelangganModel->save([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'), 
            'nomor_hp'       => $this->request->getPost('nomor_hp')
        ]);
        return redirect()->to('/pelanggan')->with('success', 'Data disimpan.');
    }

    public function edit(int $id) {
        return view('master/pelanggan/edit', [
            'title' => 'Edit Pelanggan',
            'pelanggan' => $this->pelangganModel->find($id) 
        ]);
    }

    public function update(int $id) {
        $this->pelangganModel->update($id, [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'), 
            'nomor_hp'       => $this->request->getPost('nomor_hp')       
        ]);
        return redirect()->to('/pelanggan')->with('success', 'Data diperbarui.');
    }

    public function delete(int $id) {
        $this->pelangganModel->delete($id); 
        return redirect()->to('/pelanggan');
    }
}