<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\GajiMekanikModel;

class GajiMekanik extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $model = new GajiMekanikModel();

        $data = [

            'title' => 'Gaji Mekanik',

            'data' => $model
                ->select('
                    gaji_harian_mekanik.*,
                    mekanik.nama_mekanik
                ')
                ->join(
                    'mekanik',
                    'mekanik.id_mekanik = gaji_harian_mekanik.id_mekanik'
                )
                ->orderBy('id_gaji', 'DESC')
                ->findAll(),

            'mekanik' => $db
                ->table('mekanik')
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
        $model = new GajiMekanikModel();

        $data = [
            'id_mekanik'    => $this->request->getPost('id_mekanik'),
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'nominal'       => $this->request->getPost('nominal'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ];

        $model->save($data);

        return redirect()->to('backend/transaksi/gaji_mekanik');
    }

    public function update($id)
    {
        $model = new GajiMekanikModel();

        $data = [
            'id_mekanik'    => $this->request->getPost('id_mekanik'),
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'nominal'       => $this->request->getPost('nominal'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ];

        $model->update($id, $data);

        return redirect()->to('backend/transaksi/gaji_mekanik');
    }

    public function delete($id)
    {
        $model = new GajiMekanikModel();

        $model->delete($id);

        return redirect()->to('backend/transaksi/gaji_mekanik');
    }
}