<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\SparepartModel;
use App\Models\Master\KategoriPartModel;
use App\Models\Master\MerekPartModel;

class Sparepart extends BaseController
{
    public function index() {
        $spModel = new SparepartModel();
        return view('master/sparepart/index', [
            'title' => 'Stok Sparepart',
            'sparepart' => $spModel->select('sparepart.*, kategori_part.nama_kategori, merek_part.nama_merek')
                                   ->join('kategori_part', 'kategori_part.id_kategori = sparepart.id_kategori') //[cite: 1]
                                   ->join('merek_part', 'merek_part.id_merek_part = sparepart.id_merek_part') //[cite: 1]
                                   ->findAll(),
            'kategori' => (new KategoriPartModel())->findAll(), 
            'merek' => (new MerekPartModel())->findAll() 
        ]);
    }

    public function store() {
        (new SparepartModel())->save([
            'id_kategori' => $this->request->getPost('id_kategori'), 
            'id_merek_part' => $this->request->getPost('id_merek_part'), 
            'nama_part' => $this->request->getPost('nama_part'), 
            'kualitas_part' => $this->request->getPost('kualitas_part'), 
            'harga_modal' => $this->request->getPost('harga_modal'), 
            'harga_jual' => $this->request->getPost('harga_jual'), 
            'stok_saat_ini' => $this->request->getPost('stok_saat_ini'), 
            'stok_minimum' => $this->request->getPost('stok_minimum') 
        ]);
        return redirect()->to('/sparepart');
    }

    public function edit(int $id) {
        $spModel = new SparepartModel();
        return view('master/sparepart/edit', [
            'title' => 'Edit Sparepart',
            'sparepart' => $spModel->find($id), 
            'kategori' => (new KategoriPartModel())->findAll(), 
            'merek' => (new MerekPartModel())->findAll() 
        ]);
    }

    public function update(int $id) {
        (new SparepartModel())->update($id, [
            'id_kategori' => $this->request->getPost('id_kategori'), 
            'id_merek_part' => $this->request->getPost('id_merek_part'), 
            'nama_part' => $this->request->getPost('nama_part'), 
            'kualitas_part' => $this->request->getPost('kualitas_part'), 
            'harga_modal' => $this->request->getPost('harga_modal'), 
            'harga_jual' => $this->request->getPost('harga_jual'), 
            'stok_saat_ini' => $this->request->getPost('stok_saat_ini'), 
            'stok_minimum' => $this->request->getPost('stok_minimum') 
        ]);
        return redirect()->to('/sparepart');
    }

    public function delete(int $id) {
        (new SparepartModel())->delete($id); 
        return redirect()->to('/sparepart');
    }
}