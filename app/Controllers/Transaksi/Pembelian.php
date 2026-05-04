<?php
namespace App\Controllers\Transaksi;
use App\Controllers\BaseController;
use App\Models\Transaksi\Stok\PembelianStokModel;
use App\Models\Transaksi\Stok\DetailPembelianModel;

class Pembelian extends BaseController
{
    public function index()
    {
        $model = new PembelianStokModel();
        return view('transaksi/pembelian/index', ['data' => $model->findAll()]);
    }
    public function save()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $beliModel = new PembelianStokModel();
            $idBeli = $beliModel->insert($this->request->getPost('header'), true);

            $detModel = new DetailPembelianModel();
            foreach ($this->request->getPost('items') as $i) {
                $i['id_pembelian'] = $idBeli;
                $detModel->insert($i);
            }

            $db->transCommit();
            return redirect()->to('/transaksi/pembelian');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back();
        }
    }
}