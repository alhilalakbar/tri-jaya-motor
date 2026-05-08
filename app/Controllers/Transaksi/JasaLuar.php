<?php
namespace App\Controllers\Transaksi;
use App\Controllers\BaseController;
use App\Models\Transaksi\Servis\JasaLuarModel;

class JasaLuar extends BaseController
{
    protected $model;
    public function __construct() { 
        $this->model = new JasaLuarModel(); 
    }

    public function index()
    {
        $db = \Config\Database::connect();
        // Ambil data jasa luar join dengan transaksi servis untuk menampilkan No Transaksi
        $dataJasa = $this->model->select('jasa_luar_bubut.*, transaksi_servis.kode_transaksi')
            ->join('transaksi_servis', 'transaksi_servis.id_transaksi = jasa_luar_bubut.id_transaksi')
            ->findAll();

        // Ambil daftar transaksi untuk dropdown di modal tambah
        $listTransaksi = $db->table('transaksi_servis')->select('id_transaksi, kode_transaksi')->get()->getResultArray();

        return view('backend/transaksi/jasa_luar/index', [
            'title'     => 'Jasa Luar (Bubut/Vendor)',
            'data'      => $dataJasa,
            'transaksi' => $listTransaksi
        ]);
    }

    public function save()
    {
        $this->model->insert($this->request->getPost());
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