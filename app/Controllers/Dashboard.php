<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // =========================
        // FILTER PERIODE
        // =========================

        $periode = $this->request->getGet('periode') ?? 'harian';

        if ($periode == 'bulanan') {

            $tanggalMulai = date('Y-m-01');
            $tanggalSelesai = date('Y-m-t');

        } else {

            $tanggalMulai = date('Y-m-d');
            $tanggalSelesai = date('Y-m-d');
        }

        // =========================
        // LABA JASA
        // =========================

        $labaJasa = $db->table('detail_jasa_servis djs')
            ->select('SUM(djs.harga_saat_transaksi + djs.biaya_tambahan) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = djs.id_transaksi')
            ->where('DATE(ts.tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tanggalSelesai)
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('ts.status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // =========================
        // LABA PART
        // =========================

        $labaPart = $db->table('detail_penggunaan_part dpp')
            ->select('SUM(dpp.subtotal - (dpp.jumlah_pakai * s.harga_modal)) AS total', false)
            ->join('sparepart s', 's.id_part = dpp.id_part')
            ->join('transaksi_servis ts', 'ts.id_transaksi = dpp.id_transaksi')
            ->where('DATE(ts.tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tanggalSelesai)
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('ts.status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // =========================
        // OMZET
        // =========================

        $omzet = $db->table('transaksi_servis')
            ->select('SUM(total_biaya) AS total', false)
            ->where('DATE(tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(tanggal_masuk) <=', $tanggalSelesai)
            ->where('status_pembayaran', 'Lunas')
            ->where('status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // =========================
        // UNIT AKTIF
        // =========================

        $unitProses = $db->table('transaksi_servis ts')
            ->select('ts.*, k.nomor_plat, m.nama_mekanik')
            ->join('kendaraan k', 'k.id_kendaraan = ts.id_kendaraan')
            ->join('mekanik m', 'm.id_mekanik = ts.id_mekanik', 'left')
            ->whereIn('ts.status_pengerjaan', [
                'Antre',
                'Diproses',
                'Menunggu Part'
            ])
            ->orderBy('ts.tanggal_masuk', 'DESC')
            ->get()->getResultArray();

        // =========================
        // STOK KRITIS
        // =========================

        $stokKritis = $db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        // =========================
        // ASET GUDANG
        // =========================

        $totalAset = $db->table('sparepart')
            ->select('SUM(stok_saat_ini * harga_modal) AS total', false)
            ->get()->getRow()->total ?? 0;

        // =========================
        // BIAYA OPERASIONAL
        // =========================

        $biayaOperasional = $db->table('biaya_operasional')
            ->select('SUM(nominal) AS total', false)
            ->where('tanggal_biaya >=', $tanggalMulai)
            ->where('tanggal_biaya <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        // =========================
        // GAJI MEKANIK
        // =========================

        $gajiMekanik = $db->table('gaji_harian_mekanik')
            ->select('SUM(nominal) AS total', false)
            ->where('tanggal_bayar >=', $tanggalMulai)
            ->where('tanggal_bayar <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        // =========================
        // TOTAL PENGELUARAN
        // =========================

        $totalPengeluaran = $biayaOperasional + $gajiMekanik;

        // =========================
        // LABA BERSIH
        // =========================

        $labaBersih = ($labaJasa + $labaPart) - $totalPengeluaran;

        // =========================
        // BELUM LUNAS
        // =========================

        $belumLunas = $db->table('transaksi_servis')
            ->where('status_pembayaran', 'Belum Lunas')
            ->countAllResults();

        // =========================
        // PEMBELIAN STOK
        // =========================

        $pembelian = $db->table('pembelian_stok')
            ->select('SUM(total_biaya_pembelian) AS total', false)
            ->where('DATE(tanggal_pembelian) >=', $tanggalMulai)
            ->where('DATE(tanggal_pembelian) <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        // =========================
        // DATA VIEW
        // =========================

        $data = [

            'title' => 'Dashboard Bengkel',

            'periode' => $periode,

            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,

            'omzet' => $omzet,

            'laba' => $labaJasa + $labaPart,

            'detail_laba_jasa' => $labaJasa,

            'detail_laba_part' => $labaPart,

            'laba_bersih' => $labaBersih,

            'total_pengeluaran' => $totalPengeluaran,

            'pembelian' => $pembelian,

            'belum_lunas' => $belumLunas,

            'unit_proses' => $unitProses,

            'stok_kritis_count' => $stokKritis,

            'total_aset_gudang' => $totalAset

        ];

        return view('dashboard', $data);
    }
}