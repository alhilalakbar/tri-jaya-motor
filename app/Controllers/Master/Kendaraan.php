<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Kendaraan\KendaraanModel;
use App\Models\Master\Entitas\PelangganModel;
use App\Models\Master\Kendaraan\TipeMotorModel;

class Kendaraan extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KendaraanModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $pel = new PelangganModel();
        $tipe = new TipeMotorModel();

        $builder = $this->model
            ->select('kendaraan.*, pelanggan.nama_pelanggan, tipe_motor.nama_tipe')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('tipe_motor', 'tipe_motor.id_tipe_motor = kendaraan.id_tipe_motor');

        if ($keyword) {
            $builder->groupStart()
                ->like('kendaraan.nomor_plat', $keyword)
                ->orLike('pelanggan.nama_pelanggan', $keyword)
                ->orLike('tipe_motor.nama_tipe', $keyword)
                ->groupEnd();
        }

        return view('backend/master/kendaraan/index', [
            'kendaraan' => $builder->findAll(),
            'pelanggan' => $pel->findAll(),
            'tipe' => $tipe->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave($this->request->getPost());
    }

    public function update($id)
    {
        return $this->handleUpdate($id, $this->request->getPost());
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}