<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Part\SparepartModel;
use App\Models\Master\Part\KategoriPartModel;
use App\Models\Master\Part\MerekPartModel;

class Sparepart extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new SparepartModel();
    }

    public function index()
    {
        $kat = new KategoriPartModel();
        $merk = new MerekPartModel();
        $data = [
            'sparepart' => $this->model->select('sparepart.*, kategori_part.nama_kategori, merek_part.nama_merek')
                ->join('kategori_part', 'kategori_part.id_kategori = sparepart.id_kategori')
                ->join('merek_part', 'merek_part.id_merek_part = sparepart.id_merek_part', 'left')->findAll(),
            'kategori' => $kat->findAll(),
            'merek' => $merk->findAll()
        ];
        return view('backend/master/sparepart/index', $data);
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