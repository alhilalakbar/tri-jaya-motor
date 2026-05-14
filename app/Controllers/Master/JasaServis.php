<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Layanan\JasaServisModel;

class JasaServis extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new JasaServisModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->model;

        if ($keyword) {
            $builder->like('nama_jasa', $keyword);
        }

        $data = [
            'data' => $builder->findAll(),
            'keyword' => $keyword
        ];

        return view('backend/master/jasa_servis/index', $data);
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