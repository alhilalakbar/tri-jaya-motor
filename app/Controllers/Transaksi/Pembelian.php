<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\Stok\PembelianStokModel;
use App\Models\Transaksi\Stok\DetailPembelianModel;

class Pembelian extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $model = new \App\Models\Transaksi\Stok\PembelianStokModel();

        $data = [

            'title' => 'Pembelian Stok',

            'data' => $model
                ->select('
                pembelian_stok.*,
                pemasok.nama_pemasok
            ')
                ->join(
                    'pemasok',
                    'pemasok.id_pemasok = pembelian_stok.id_pemasok'
                )
                ->orderBy('id_pembelian', 'DESC')
                ->findAll(),

            'pemasok' => $db
                ->table('pemasok')
                ->get()
                ->getResultArray(),

            'part_list' => $db
                ->table('sparepart')
                ->get()
                ->getResultArray(),
        ];

        return view(
            'backend/transaksi/pembelian/index',
            $data
        );
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
            return redirect()->to('backend/transaksi/pembelian');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back();
        }
    }


    public function detail($id)
    {
        $db = \Config\Database::connect();

        // Mengambil data Header Pembelian
        $pembelian = $db
            ->table('pembelian_stok')
            ->select('
            pembelian_stok.*, 
            pemasok.nama_pemasok,
            pembelian_stok.total_biaya_pembelian AS total_harga
        ')
            ->join('pemasok', 'pemasok.id_pemasok = pembelian_stok.id_pemasok')
            ->where('id_pembelian', $id)
            ->get()
            ->getRowArray();

        // Mengambil data Detail Item
        $detail = $db
            ->table('detail_pembelian_stok')
            ->select('
            detail_pembelian_stok.*, 
            sparepart.nama_part,
            detail_pembelian_stok.jumlah_beli AS jumlah,
            detail_pembelian_stok.harga_beli_satuan AS harga_beli
        ')
            ->join('sparepart', 'sparepart.id_part = detail_pembelian_stok.id_part')
            ->where('id_pembelian', $id)
            ->get()
            ->getResultArray();

        return view('backend/transaksi/pembelian/detail', [
            'title' => 'Detail Pembelian',
            'h'     => $pembelian,
            'items' => $detail
        ]);
    }
}