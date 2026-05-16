<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\BiayaOperasionalModel;

class BiayaOperasional extends BaseController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->model = new BiayaOperasionalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Biaya Operasional',

            'data' => $this->model
                ->select('
                    biaya_operasional.*,
                    kategori_biaya_operasional.nama_kategori,
                    pengguna.nama_pengguna
                ')
                ->join(
                    'kategori_biaya_operasional',
                    'kategori_biaya_operasional.id_kategori_biaya = biaya_operasional.id_kategori_biaya'
                )
                ->join(
                    'pengguna',
                    'pengguna.id_pengguna = biaya_operasional.id_pengguna',
                    'left'
                )
                ->orderBy('id_biaya_operasional', 'DESC')
                ->findAll(),

            'kategori' => $this->db
                ->table('kategori_biaya_operasional')
                ->orderBy('nama_kategori', 'ASC')
                ->get()
                ->getResultArray(),
        ];

        return view('backend/transaksi/biaya_operasional/index', $data);
    }

    public function save()
    {
        $data = [
            'id_kategori_biaya' => $this->request->getPost('id_kategori_biaya'),
            'id_pengguna' => session()->get('id_pengguna'),
            'tanggal_biaya' => date('Y-m-d H:i:s'),
            'nominal' => $this->request->getPost('nominal'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        if (!$this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', 'Biaya operasional berhasil ditambahkan.');
    }

    public function update($id)
    {
        $data = [
            'id_kategori_biaya' => $this->request->getPost('id_kategori_biaya'),
            'id_pengguna' => session()->get('id_pengguna'),
            'nominal' => $this->request->getPost('nominal'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', 'Biaya operasional berhasil diperbarui.');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);

            return redirect()->back()
                ->with('success', 'Biaya operasional berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Data tidak dapat dihapus.');
        }
    }
}