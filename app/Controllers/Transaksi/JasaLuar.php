<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\Servis\JasaLuarModel;

class JasaLuar extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new JasaLuarModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $dataJasa = $this->model
            ->select('jasa_luar_bubut.*, transaksi_servis.kode_transaksi')
            ->join(
                'transaksi_servis',
                'transaksi_servis.id_transaksi = jasa_luar_bubut.id_transaksi'
            )
            ->findAll();

        $listTransaksi = $db
            ->table('transaksi_servis')
            ->select('id_transaksi, kode_transaksi')
            ->get()
            ->getResultArray();

        return view('backend/transaksi/jasa_luar/index', [
            'title' => 'Jasa Luar (Bubut/Vendor)',
            'data' => $dataJasa,
            'transaksi' => $listTransaksi
        ]);
    }

    public function save()
    {
        if (!$this->model->save($this->request->getPost())) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', 'Data jasa luar berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (!$this->model->update($id, $this->request->getPost())) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', 'Data jasa luar berhasil diperbarui.');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);

            return redirect()->back()
                ->with('success', 'Data jasa luar berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Data tidak dapat dihapus.');
        }
    }
}