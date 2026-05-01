<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Master\MekanikModel;

class Mekanik extends BaseController
{
    protected MekanikModel $mekanikModel;

    public function __construct() {
        $this->mekanikModel = new MekanikModel();
    }

    public function index() {
        return view('master/mekanik/index', [
            'title' => 'Data Mekanik',
            'mekanik' => $this->mekanikModel->findAll() 
        ]);
    }

    public function store() {
        $this->mekanikModel->save(['nama_mekanik' => $this->request->getPost('nama_mekanik')]); 
        return redirect()->to('/mekanik');
    }

    public function edit(int $id) {
        return view('master/mekanik/edit', [
            'title' => 'Edit Mekanik',
            'mekanik' => $this->mekanikModel->find($id) 
        ]);
    }

    public function update(int $id) {
        $this->mekanikModel->update($id, ['nama_mekanik' => $this->request->getPost('nama_mekanik')]);
        return redirect()->to('/mekanik');
    }

    public function delete(int $id) {
        $this->mekanikModel->delete($id); 
        return redirect()->to('/mekanik');
    }
}