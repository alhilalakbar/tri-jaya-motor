<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Kendaraan\TipeMotorModel;
use App\Models\Master\Kendaraan\MerkMotorModel;

class TipeMotor extends BaseCrudController
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

        $builder = $this->model
            ->select('tipe_motor.*, merek_motor.nama_merek_motor')
            ->join('merek_motor', 'merek_motor.id_merek_motor = tipe_motor.id_merek_motor');

        if ($keyword) {
            $builder->groupStart()
                ->like('tipe_motor.nama_tipe', $keyword)
                ->orLike('tipe_motor.jenis_kendaraan', $keyword)
                ->orLike('merek_motor.nama_merek_motor', $keyword)
                ->groupEnd();
        }

        return view('backend/master/tipe_motor/index', [
            'tipe' => $builder->findAll(),
            'merk' => $merk->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave([
            'id_merek_motor' => $this->request->getPost('id_merek_motor'),
            'nama_tipe' => $this->request->getPost('nama_tipe'),
            'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')
        ]);
    }

    public function update($id)
    {
        return $this->handleUpdate($id, [
            'id_merek_motor' => $this->request->getPost('id_merek_motor'),
            'nama_tipe' => $this->request->getPost('nama_tipe'),
            'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan')
        ]);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}