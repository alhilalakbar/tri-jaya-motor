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

        $model = new PembelianStokModel();

        $data = [
            'title' => 'Pembelian Stok',

            'data' => $model
                ->select('
                    pembelian_stok.*,
                    pemasok.nama_pemasok,
                    pengguna.nama_pengguna
                ')
                ->join(
                    'pemasok',
                    'pemasok.id_pemasok = pembelian_stok.id_pemasok'
                )
                ->join(
                    'pengguna',
                    'pengguna.id_pengguna = pembelian_stok.id_pengguna',
                    'left'
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

        return view('backend/transaksi/pembelian/index', $data);
    }

    public function save()
    {
        $db = \Config\Database::connect();

        $db->transBegin();

        try {
            $header = $this->request->getPost('header');
            $items = $this->request->getPost('items');

            if (empty($header['id_pemasok'])) {
                throw new \Exception('Pemasok wajib dipilih.');
            }

            if (!is_array($items) || empty($items)) {
                throw new \Exception('Minimal satu sparepart harus dipilih.');
            }

            foreach ($items as $item) {
                if (
                    empty($item['id_part']) ||
                    empty($item['jumlah_beli']) ||
                    empty($item['harga_beli_satuan'])
                ) {
                    throw new \Exception('Data detail pembelian tidak lengkap.');
                }

                if ((int) $item['jumlah_beli'] <= 0) {
                    throw new \Exception('Jumlah pembelian harus lebih dari 0.');
                }

                if ((float) $item['harga_beli_satuan'] <= 0) {
                    throw new \Exception('Harga beli harus lebih dari 0.');
                }
            }

            $header['tanggal_pembelian'] = date('Y-m-d H:i:s');
            $header['id_pengguna'] = session()->get('id_pengguna');

            $beliModel = new PembelianStokModel();
            $idBeli = $beliModel->insert($header, true);

            if (!$idBeli) {
                throw new \Exception('Gagal menyimpan data pembelian.');
            }

            $detModel = new DetailPembelianModel();

            foreach ($items as $item) {
                $item['id_pembelian'] = $idBeli;
                $item['qty_tersisa'] = $item['jumlah_beli'];
                $detModel->insert($item);
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi pembelian gagal disimpan.');
            }

            $db->transCommit();

            return redirect()
                ->to('transaksi/pembelian')
                ->with('success', 'Pembelian stok berhasil disimpan.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        $pembelian = $db
            ->table('pembelian_stok')
            ->select('
                pembelian_stok.*, 
                pemasok.nama_pemasok,
                pengguna.nama_pengguna,
                pembelian_stok.total_biaya_pembelian AS total_harga
            ')
            ->join(
                'pemasok',
                'pemasok.id_pemasok = pembelian_stok.id_pemasok'
            )
            ->join(
                'pengguna',
                'pengguna.id_pengguna = pembelian_stok.id_pengguna',
                'left'
            )
            ->where('id_pembelian', $id)
            ->get()
            ->getRowArray();

        $detail = $db
            ->table('detail_pembelian_stok')
            ->select('
                detail_pembelian_stok.*, 
                sparepart.nama_part,
                detail_pembelian_stok.jumlah_beli AS jumlah,
                detail_pembelian_stok.harga_beli_satuan AS harga_beli
            ')
            ->join(
                'sparepart',
                'sparepart.id_part = detail_pembelian_stok.id_part'
            )
            ->where('id_pembelian', $id)
            ->get()
            ->getResultArray();

        return view('backend/transaksi/pembelian/detail', [
            'title' => 'Detail Pembelian',
            'h' => $pembelian,
            'items' => $detail
        ]);
    }
}