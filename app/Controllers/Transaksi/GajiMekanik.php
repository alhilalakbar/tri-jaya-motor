<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\GajiMekanikModel;

class GajiMekanik extends BaseController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->model = new GajiMekanikModel();
    }

    public function index()
    {
        $data = [

            'title' => 'Gaji Mekanik',

            'data' => $this->model

                ->select('
                    gaji_harian_mekanik.*,
                    mekanik.nama_mekanik,
                    pengguna.nama_pengguna
                ')

                ->join(
                    'mekanik',
                    'mekanik.id_mekanik = gaji_harian_mekanik.id_mekanik'
                )

                ->join(
                    'pengguna',
                    'pengguna.id_pengguna = gaji_harian_mekanik.id_pengguna',
                    'left'
                )

                ->orderBy('id_gaji', 'DESC')

                ->findAll(),

            'mekanik' => $this->db

                ->table('mekanik')

                ->get()

                ->getResultArray(),

            'pengguna' => $this->db

                ->table('pengguna')

                ->get()

                ->getResultArray(),
        ];

        return view(
            'backend/transaksi/gaji_mekanik/index',
            $data
        );
    }

    public function save()
    {
        $data = [

            'id_mekanik' =>
                $this->request->getPost('id_mekanik'),

            'id_pengguna' =>
                session()->get('id_pengguna'),

            'tanggal_bayar' =>
                date('Y-m-d H:i:s'),

            'nominal' =>
                $this->request->getPost('nominal'),

            'keterangan' =>
                $this->request->getPost('keterangan'),
        ];

        $this->model->save($data);

        return redirect()->to(
            base_url('backend/transaksi/gaji_mekanik')
        );
    }

    public function update($id)
    {
        $data = [

            'id_mekanik' =>
                $this->request->getPost('id_mekanik'),

            'id_pengguna' =>
                session()->get('id_pengguna'),

            'nominal' =>
                $this->request->getPost('nominal'),

            'keterangan' =>
                $this->request->getPost('keterangan'),
        ];

        $this->model->update($id, $data);

        return redirect()->to(
            base_url('backend/transaksi/gaji_mekanik')
        );
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect()->to(
            base_url('backend/transaksi/gaji_mekanik')
        );
    }
}