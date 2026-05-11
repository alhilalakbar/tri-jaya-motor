<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // =========================
        // FILTER PERIODE & KALENDER
        // =========================
        $periode = $this->request->getGet('periode') ?? 'harian';
        $tglInputMulai = $this->request->getGet('tgl_mulai');
        $tglInputSelesai = $this->request->getGet('tgl_selesai');

        if ($tglInputMulai && $tglInputSelesai) {
            $tanggalMulai = $tglInputMulai;
            $tanggalSelesai = $tglInputSelesai;
            $periode = 'custom';
        } else {
            if ($periode == 'bulanan') {
                $tanggalMulai = date('Y-m-01');
                $tanggalSelesai = date('Y-m-t');
            } else {
                $tanggalMulai = date('Y-m-d');
                $tanggalSelesai = date('Y-m-d');
            }
        }

        // =========================
        // QUERY DATA UTAMA
        // =========================

        // LABA JASA
        $labaJasa = $db->table('detail_jasa_servis djs')
            ->select('SUM(djs.harga_saat_transaksi + djs.biaya_tambahan) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = djs.id_transaksi')
            ->where('DATE(ts.tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tanggalSelesai)
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('ts.status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // LABA PART
        $labaPart = $db->table('detail_penggunaan_part dpp')
            ->select('SUM(dpp.subtotal - (dpp.jumlah_pakai * s.harga_modal)) AS total', false)
            ->join('sparepart s', 's.id_part = dpp.id_part')
            ->join('transaksi_servis ts', 'ts.id_transaksi = dpp.id_transaksi')
            ->where('DATE(ts.tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tanggalSelesai)
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('ts.status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // OMZET (INCOME)
        $omzet = $db->table('transaksi_servis')
            ->select('SUM(total_biaya) AS total', false)
            ->where('DATE(tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(tanggal_masuk) <=', $tanggalSelesai)
            ->where('status_pembayaran', 'Lunas')
            ->where('status_pengerjaan', 'Selesai')
            ->get()->getRow()->total ?? 0;

        // TOTAL TRANSAKSI
        $totalTransaksi = $db->table('transaksi_servis')
            ->where('DATE(tanggal_masuk) >=', $tanggalMulai)
            ->where('DATE(tanggal_masuk) <=', $tanggalSelesai)
            ->countAllResults();

        // UNIT AKTIF (MONITORING)
        $unitProses = $db->table('transaksi_servis ts')
            ->select('ts.*, k.nomor_plat, m.nama_mekanik')
            ->join('kendaraan k', 'k.id_kendaraan = ts.id_kendaraan')
            ->join('mekanik m', 'm.id_mekanik = ts.id_mekanik', 'left')
            ->whereIn('ts.status_pengerjaan', ['Antre', 'Diproses', 'Menunggu Part'])
            ->orderBy('ts.tanggal_masuk', 'DESC')
            ->get()->getResultArray();

        // PENGELUARAN
        $biayaOperasional = $db->table('biaya_operasional')
            ->select('SUM(nominal) AS total', false)
            ->where('DATE(tanggal_biaya) >=', $tanggalMulai)
            ->where('DATE(tanggal_biaya) <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        $gajiMekanik = $db->table('gaji_harian_mekanik')
            ->select('SUM(nominal) AS total', false)
            ->where('DATE(tanggal_bayar) >=', $tanggalMulai)
            ->where('DATE(tanggal_bayar) <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        $totalPengeluaran = $biayaOperasional + $gajiMekanik;
        $labaKotor = $labaJasa + $labaPart;
        $labaBersih = $labaKotor - $totalPengeluaran;

        // --- LOGIKA WARNA LABA BERDASARKAN HASIL [cite: 70-73, 118] ---
        $labaColor = '#6B7280'; // Default Abu-abu jika nol [cite: 73]
        if ($labaBersih > 0) {
            $labaColor = '#22C55E'; // Hijau jika positif [cite: 71, 81]
        } elseif ($labaBersih < 0) {
            $labaColor = '#EF4444'; // Merah jika negatif [cite: 72, 82]
        }

        // =========================
        // DATA INFORMASI GUDANG & PIUTANG
        // =========================

        $totalAset = $db->table('sparepart')
            ->select('SUM(stok_saat_ini * harga_modal) AS total', false)
            ->get()->getRow()->total ?? 0;

        $pembelian = $db->table('pembelian_stok')
            ->select('SUM(total_biaya_pembelian) AS total', false)
            ->where('DATE(tanggal_pembelian) >=', $tanggalMulai)
            ->where('DATE(tanggal_pembelian) <=', $tanggalSelesai)
            ->get()->getRow()->total ?? 0;

        $belumLunas = $db->table('transaksi_servis')
            ->where('status_pembayaran', 'Belum Lunas')
            ->countAllResults();

        $stokKritis = $db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        // DATA UNTUK VIEW
        $data = [
            'title' => 'Dashboard Bengkel',
            'periode' => $periode,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'omzet' => $omzet,
            'total_transaksi' => $totalTransaksi,
            'laba_kotor' => $labaKotor,
            'laba_bersih' => $labaBersih,
            'laba_color' => $labaColor, 
            'total_pengeluaran' => $totalPengeluaran,
            'biaya_operasional' => $biayaOperasional,
            'gaji_mekanik' => $gajiMekanik,
            'unit_proses' => $unitProses,
            'total_aset_gudang' => $totalAset,
            'pembelian' => $pembelian,
            'belum_lunas' => $belumLunas,
            'stok_kritis_count' => $stokKritis,
        ];

        return view('dashboard', $data);
    }
}