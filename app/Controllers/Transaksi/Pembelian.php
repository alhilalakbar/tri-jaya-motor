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

            $header = $this->request->getPost('header');

            $header['tanggal_pembelian'] =
                date('Y-m-d H:i:s');

            $header['id_pengguna'] =
                session()->get('id_pengguna');

            $beliModel = new PembelianStokModel();

            $idBeli = $beliModel->insert(
                $header,
                true
            );

            if (!$idBeli) {

                throw new \Exception(
                    'Gagal menyimpan data pembelian.'
                );
            }

            $detModel = new DetailPembelianModel();

            $items = $this->request->getPost('items');

            if (is_array($items)) {

                foreach ($items as $i) {

                    $i['id_pembelian'] = $idBeli;

                    $detModel->insert($i);
                }
            }

            if ($db->transStatus() === false) {

                throw new \Exception(
                    'Transaksi pembelian gagal disimpan.'
                );
            }

            $db->transCommit();

            return redirect()

                ->to('backend/transaksi/pembelian')

                ->with(
                    'success',
                    'Pembelian stok berhasil disimpan.'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            return redirect()

                ->back()

                ->withInput()

                ->with(
                    'error',
                    $e->getMessage()
                );
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