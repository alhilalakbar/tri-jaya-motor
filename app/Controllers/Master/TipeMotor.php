<?php
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\Kendaraan\TipeMotorModel;
use App\Models\Master\Kendaraan\MerkMotorModel;

class TipeMotor extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new TipeMotorModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $merk = new MerkMotorModel();

        $builder = $this->model->select('tipe_motor.*, merek_motor.nama_merek_motor')
            ->join('merek_motor', 'merek_motor.id_merek_motor = tipe_motor.id_merek_motor');

        if ($keyword) {
            $builder->groupStart()
                ->like('tipe_motor.nama_tipe', $keyword)
                ->orLike('tipe_motor.jenis_kendaraan', $keyword)
                ->orLike('merek_motor.nama_merek_motor', $keyword)
                ->groupEnd();
        }

        $data = [
            'tipe' => $builder->findAll(),
            'merk' => $merk->findAll(),
            'keyword' => $keyword
        ];

        return view('backend/master/tipe_motor/index', $data);
    }
    public function save()
    {
        $this->model->save(['id_merek_motor' => $this->request->getPost('id_merek_motor'), 'nama_tipe' => $this->request->getPost('nama_tipe'), 'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')]);
        return redirect()->back();
    }
    public function update($id)
    {
        $this->model->update($id, ['id_merek_motor' => $this->request->getPost('id_merek_motor'), 'nama_tipe' => $this->request->getPost('nama_tipe'), 'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')]);
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back();
    }
}