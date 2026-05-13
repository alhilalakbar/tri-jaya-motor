<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\Laporan\TransaksiServisLaporanModel;
use App\Models\Laporan\StokSparepartLaporanModel;
use App\Models\Laporan\PerformaMekanikLaporanModel;
use App\Models\Laporan\PembelianStokLaporanModel;
use App\Models\Laporan\PengeluaranLaporanModel;
use App\Models\Laporan\LoyalitasLaporanModel;
use App\Models\Laporan\LabaRugiLaporanModel;

class Laporan extends BaseController
{
    protected $helpers = ['date', 'number'];

    /**
     * Mendapatkan rentang tanggal dari request atau default (bulan berjalan)
     */
    private function getDateRange()
    {
        return [
            'tgl_mulai' => $this->request->getGet('tgl_mulai') ?? date('Y-m-01'),
            'tgl_akhir' => $this->request->getGet('tgl_akhir') ?? date('Y-m-d')
        ];
    }

    /**
     * Laporan Transaksi Servis
     * Kolom filter: tanggal_masuk
     */
    public function transaksi()
    {
        $range = $this->getDateRange();
        $model = new TransaksiServisLaporanModel();

        $laporan = $model->where('tanggal_masuk >=', $range['tgl_mulai'] . ' 00:00:00')
                         ->where('tanggal_masuk <=', $range['tgl_akhir'] . ' 23:59:59')
                         ->findAll();

        $data = array_merge([
            'judul'   => 'Laporan Transaksi Servis',
            'laporan' => $laporan
        ], $range);

        return view('backend/laporan/transaksi', $data);
    }

    /**
     * Laporan Stok Sparepart
     * Sifatnya real-time (kondisi gudang saat ini), jadi tidak pakai filter tanggal
     */
    public function stok()
    {
        $model = new StokSparepartLaporanModel();
        $data = [
            'judul'   => 'Laporan Stok Sparepart',
            'laporan' => $model->findAll(),
            'tgl_mulai' => date('Y-m-01'), // Untuk sinkronisasi form filter saja
            'tgl_akhir' => date('Y-m-d')
        ];
        return view('backend/laporan/stok', $data);
    }

    /**
     * Laporan Performa Mekanik
     */
    public function mekanik()
    {
        $range = $this->getDateRange();
        $model = new PerformaMekanikLaporanModel();

        // Note: Filter ini bekerja jika view_laporan_performa_mekanik memiliki kolom tanggal
        $laporan = $model->findAll(); 

        $data = array_merge([
            'judul'   => 'Laporan Performa Mekanik',
            'laporan' => $laporan
        ], $range);

        return view('backend/laporan/mekanik', $data);
    }

    /**
     * Laporan Pembelian Stok (Barang Masuk)
     * Kolom filter: tanggal_pembelian
     */
    public function pembelian()
    {
        $range = $this->getDateRange();
        $model = new PembelianStokLaporanModel();

        $laporan = $model->where('tanggal_pembelian >=', $range['tgl_mulai'] . ' 00:00:00')
                         ->where('tanggal_pembelian <=', $range['tgl_akhir'] . ' 23:59:59')
                         ->findAll();

        $data = array_merge([
            'judul'   => 'Laporan Pembelian Stok',
            'laporan' => $laporan
        ], $range);

        return view('backend/laporan/pembelian', $data);
    }

    /**
     * Laporan Pengeluaran (Biaya Operasional & Gaji)
     * Kolom filter: tanggal
     */
    public function pengeluaran()
    {
        $range = $this->getDateRange();
        $model = new PengeluaranLaporanModel();

        $laporan = $model->where('tanggal >=', $range['tgl_mulai'] . ' 00:00:00')
                         ->where('tanggal <=', $range['tgl_akhir'] . ' 23:59:59')
                         ->findAll();

        $data = array_merge([
            'judul'   => 'Laporan Pengeluaran',
            'laporan' => $laporan
        ], $range);

        return view('backend/laporan/pengeluaran', $data);
    }

    /**
     * Laporan Loyalitas Pelanggan
     */
    public function loyalitas()
    {
        $range = $this->getDateRange();
        $model = new LoyalitasLaporanModel();

        $data = array_merge([
            'judul'   => 'Laporan Loyalitas Pelanggan',
            'laporan' => $model->findAll()
        ], $range);

        return view('backend/laporan/loyalitas', $data);
    }

    /**
     * Laporan Laba Rugi (Ringkasan)
     */
    public function labaRugi()
    {
        $range = $this->getDateRange();
        $model = new LabaRugiLaporanModel();

        // Mengambil data ringkasan laba rugi
        $data = array_merge([
            'judul' => 'Laporan Laba Rugi',
            'laba'  => $model->first() 
        ], $range);

        return view('backend/laporan/laba_rugi', $data);
    }
}