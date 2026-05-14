<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Part\MerekPartModel;

class MerekPart extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new MerekPartModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_merek_part', $keyword);
        }

        return view('backend/master/merk_part/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }
    public function save()
    {
        $this->model->save(['nama_merek_part' => $this->request->getPost('nama_merek_part')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_merek_part' => $this->request->getPost('nama_merek_part')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}