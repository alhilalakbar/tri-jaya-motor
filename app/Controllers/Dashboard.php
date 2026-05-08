<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        $labaJasa = $db->table('detail_jasa_servis djs')
            ->select('SUM(djs.harga_saat_transaksi + djs.biaya_tambahan) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = djs.id_transaksi')
            ->where('DATE(ts.tanggal_masuk)', $today)
            ->where('ts.status_pembayaran', 'Lunas')
            ->get()->getRow()->total ?? 0;


        $labaPart = $db->table('detail_penggunaan_part dpp')
            ->select('SUM(dpp.subtotal - (dpp.jumlah_pakai * s.harga_modal)) AS total', false)
            ->join('sparepart s', 's.id_part = dpp.id_part')
            ->join('transaksi_servis ts', 'ts.id_transaksi = dpp.id_transaksi')
            ->where('DATE(ts.tanggal_masuk)', $today)
            ->where('ts.status_pembayaran', 'Lunas')
            ->get()->getRow()->total ?? 0;

        $unitProses = $db->table('transaksi_servis ts')
            ->select('ts.*, k.nomor_plat, m.nama_mekanik')
            ->join('kendaraan k', 'k.id_kendaraan = ts.id_kendaraan')
            ->join('mekanik m', 'm.id_mekanik = ts.id_mekanik', 'left')
            ->where('ts.status_pengerjaan', 'Diproses')
            ->get()->getResultArray();

        $stokKritis = $db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        $totalAset = $db->table('sparepart')
            ->select('SUM(stok_saat_ini * harga_modal) AS total', false)
            ->get()->getRow()->total ?? 0;

        $data = [
            'title'               => 'Dashboard Bengkel',
            'laba_hari_ini'       => $labaJasa + $labaPart,
            'detail_laba_jasa'    => $labaJasa,
            'detail_laba_part'    => $labaPart,
            'unit_proses'         => $unitProses,
            'stok_kritis_count'   => $stokKritis,
            'total_aset_gudang'   => $totalAset
        ];

        return view('dashboard', $data);
    }
}