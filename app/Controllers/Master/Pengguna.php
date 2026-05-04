<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Entitas\PenggunaModel;

class Pengguna extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new PenggunaModel();
    }

    public function index()
    {
        return view('master/pengguna/index', ['data' => $this->model->findAll()]);
    }
    public function save()
    {
        $data = $this->request->getPost();
        $data['kata_sandi'] = password_hash($data['kata_sandi'], PASSWORD_DEFAULT);
        $this->model->save($data);
        return redirect()->back();
    }
    public function update($id)
    {
        $data = $this->request->getPost();
        if (!empty($data['kata_sandi']))
            $data['kata_sandi'] = password_hash($data['kata_sandi'], PASSWORD_DEFAULT);
        else
            unset($data['kata_sandi']);
        $this->model->update($id, $data);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}