<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Entitas\MekanikModel;

class Mekanik extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new MekanikModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_mekanik', $keyword);
        }

        return view('backend/master/mekanik/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }
    public function save()
    {
        $this->model->save(['nama_mekanik' => $this->request->getPost('nama_mekanik')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_mekanik' => $this->request->getPost('nama_mekanik')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}