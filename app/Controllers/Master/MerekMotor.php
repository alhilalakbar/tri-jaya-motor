<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\MerkMotorModel;

class MerekMotor extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new MerkMotorModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_merek_motor', $keyword);
        }

        return view('backend/master/merk_motor/index', [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ]);
    }
    public function save()
    {
        $this->model->save(['nama_merek_motor' => $this->request->getPost('nama_merek_motor')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['nama_merek_motor' => $this->request->getPost('nama_merek_motor')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}