<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\PemasokModel;

class Pemasok extends BaseController
{
    protected PemasokModel $pemasokModel;

    public function __construct() {
        $this->pemasokModel = new PemasokModel();
    }

    public function index() {
        return view('master/pemasok/index', [
            'title' => 'Data Pemasok',
            'pemasok' => $this->pemasokModel->findAll() 
        ]);
    }

    public function store() {
        $this->pemasokModel->save([
            'nama_pemasok' => $this->request->getPost('nama_pemasok'), 
            'nomor_hp_pemasok' => $this->request->getPost('nomor_hp_pemasok'), 
            'alamat_pemasok' => $this->request->getPost('alamat_pemasok') 
        ]);
        return redirect()->to('/pemasok');
    }

    public function edit(int $id) {
        return view('master/pemasok/edit', [
            'title' => 'Edit Pemasok',
            'pemasok' => $this->pemasokModel->find($id) 
        ]);
    }

    public function update(int $id) {
        $this->pemasokModel->update($id, [
            'nama_pemasok' => $this->request->getPost('nama_pemasok'), 
            'nomor_hp_pemasok' => $this->request->getPost('nomor_hp_pemasok'), 
            'alamat_pemasok' => $this->request->getPost('alamat_pemasok') 
        ]);
        return redirect()->to('/pemasok');
    }

    public function delete(int $id) {
        $this->pemasokModel->delete($id); 
        return redirect()->to('/pemasok');
    }
}