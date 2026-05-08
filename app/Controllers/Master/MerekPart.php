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
        return view('backend/master/merk_part/index', ['data' => $this->model->findAll()]);
    }
    public function save()
    {
        $this->model->save(['nama_merek' => $this->request->getPost('nama_merek')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_merek' => $this->request->getPost('nama_merek')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}