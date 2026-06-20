<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getKeuanganMetrics($tglMulai, $tglSelesai)
    {
        $labaJasa = $this->db->table('detail_jasa_servis djs')
            ->select('SUM(djs.harga_saat_transaksi + djs.biaya_tambahan) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = djs.id_transaksi')
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('DATE(ts.tanggal_masuk) >=', $tglMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        $labaPart = $this->db->table('detail_penggunaan_part dpp')
            ->select('SUM((dpp.harga_satuan_jual * dpp.jumlah_pakai) - (dpp.jumlah_pakai * s.harga_modal)) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = dpp.id_transaksi')
            ->join('sparepart s', 's.id_part = dpp.id_part')
            ->where('ts.status_pembayaran', 'Lunas')
            ->where('DATE(ts.tanggal_masuk) >=', $tglMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        $operasional = $this->db->table('biaya_operasional')
            ->select('SUM(nominal) AS total', false)
            ->where('DATE(tanggal_biaya) >=', $tglMulai)
            ->where('DATE(tanggal_biaya) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        $gaji = $this->db->table('gaji_harian_mekanik')
            ->select('SUM(nominal) AS total', false)
            ->where('DATE(tanggal_bayar) >=', $tglMulai)
            ->where('DATE(tanggal_bayar) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        $pembelian = $this->db->table('pembelian_stok')
            ->select('SUM(total_biaya_pembelian) AS total', false)
            ->where('DATE(tanggal_pembelian) >=', $tglMulai)
            ->where('DATE(tanggal_pembelian) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        $totalTransaksi = $this->db->table('transaksi_servis')
            ->where('status_pembayaran', 'Lunas')
            ->where('DATE(tanggal_masuk) >=', $tglMulai)
            ->where('DATE(tanggal_masuk) <=', $tglSelesai)
            ->countAllResults();

        $omzet = $this->db->table('transaksi_servis')
            ->select('SUM(total_biaya) AS total', false)
            ->where('status_pembayaran', 'Lunas')
            ->where('DATE(tanggal_masuk) >=', $tglMulai)
            ->where('DATE(tanggal_masuk) <=', $tglSelesai)
            ->get()->getRow()->total ?? 0;

        return [
            'laba_jasa' => $labaJasa,
            'laba_part' => $labaPart,
            'laba_kotor' => $labaJasa + $labaPart,
            'biaya_operasional' => $operasional,
            'gaji_mekanik' => $gaji,
            'total_pengeluaran' => $operasional + $gaji,
            'pembelian' => $pembelian,
            'omzet' => $omzet,
            'total_transaksi' => $totalTransaksi
        ];
    }

    public function getMetrikUmum()
    {
        $stokKritis = $this->db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        $belumLunas = $this->db->table('transaksi_servis')
            ->where('status_pembayaran', 'Belum Lunas')
            ->countAllResults();

        $asetGudang = $this->db->table('sparepart')
            ->select('SUM(stok_saat_ini * harga_modal) AS total', false)
            ->get()->getRow()->total ?? 0;

        return [
            'stok_kritis' => $stokKritis,
            'belum_lunas' => $belumLunas,
            'aset_gudang' => $asetGudang
        ];
    }

    public function getAntrean($status)
    {
        return $this->db->table('transaksi_servis')
            ->select('transaksi_servis.*, kendaraan.nomor_plat, pelanggan.nama_pelanggan, mekanik.nama_mekanik')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->where('transaksi_servis.status_pengerjaan', $status)
            ->orderBy('transaksi_servis.tanggal_masuk', 'ASC')
            ->get()->getResultArray();
    }
}