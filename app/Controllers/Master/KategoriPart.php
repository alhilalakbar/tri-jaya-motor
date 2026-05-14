<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Part\KategoriPartModel;

class KategoriPart extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new KategoriPartModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_kategori', $keyword);
        }

        return view('backend/master/kategori_part/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }
    public function save()
    {
        $this->model->save(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}