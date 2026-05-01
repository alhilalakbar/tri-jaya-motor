<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\JasaServisModel;

class Jasa extends BaseController
{
    protected JasaServisModel $jasaModel;

    public function __construct() {
        $this->jasaModel = new JasaServisModel();
    }

    public function index() {
        return view('master/jasa/index', [
            'title' => 'Daftar Jasa',
            'jasa' => $this->jasaModel->findAll() 
        ]);
    }

    public function store() {
        $this->jasaModel->save([
            'nama_jasa' => $this->request->getPost('nama_jasa'), 
            'biaya_standar' => $this->request->getPost('biaya_standar') 
        ]);
        return redirect()->to('/jasa');
    }

    public function edit(int $id) {
        return view('master/jasa/edit', [
            'title' => 'Edit Jasa',
            'jasa' => $this->jasaModel->find($id) 
        ]);
    }

    public function update(int $id) {
        $this->jasaModel->update($id, [
            'nama_jasa' => $this->request->getPost('nama_jasa'), 
            'biaya_standar' => $this->request->getPost('biaya_standar')
        ]);
        return redirect()->to('/jasa');
    }

    public function delete(int $id) {
        $this->jasaModel->delete($id); 
        return redirect()->to('/jasa');
    }
}