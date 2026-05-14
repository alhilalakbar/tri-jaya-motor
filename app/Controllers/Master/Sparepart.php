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
        $keyword = $this->request->getGet('keyword');
        $kat = new KategoriPartModel();
        $merk = new MerekPartModel();

        $builder = $this->model->select('sparepart.*, kategori_part.nama_kategori, merek_part.nama_merek_part')
            ->join('kategori_part', 'kategori_part.id_kategori = sparepart.id_kategori')
            ->join('merek_part', 'merek_part.id_merek_part = sparepart.id_merek_part', 'left');

        if ($keyword) {
            $builder->groupStart()
                ->like('sparepart.nama_part', $keyword)
                ->orLike('kategori_part.nama_kategori', $keyword)
                ->orLike('merek_part.nama_merek_part', $keyword)
                ->groupEnd();
        }

        $data = [
            'sparepart' => $builder->findAll(),
            'kategori' => $kat->findAll(),
            'merek' => $merk->findAll(),
            'keyword' => $keyword
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