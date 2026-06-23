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
            ->select('COALESCE(SUM(djs.harga_saat_transaksi + djs.biaya_tambahan),0) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = djs.id_transaksi')
            ->where('ts.status_transaksi', 'Lunas')
            ->where('DATE(ts.tanggal_masuk) >=', $tglMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $labaPart = $this->db->table('detail_penggunaan_part dpp')
            ->select(
                'COALESCE(
                    SUM(
                        (dpp.harga_satuan_jual * dpp.jumlah_pakai)
                        -
                        (dpp.harga_satuan_modal * dpp.jumlah_pakai)
                    ),
                0) AS total',
                false
            )
            ->join('transaksi_servis ts', 'ts.id_transaksi = dpp.id_transaksi')
            ->where('ts.status_transaksi', 'Lunas')
            ->where('DATE(ts.tanggal_masuk) >=', $tglMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $labaJasaLuar = $this->db->table('jasa_luar_bubut jlb')
            ->select('COALESCE(SUM(jlb.tagihan_ke_pelanggan - jlb.biaya_modal_vendor), 0) AS total', false)
            ->join('transaksi_servis ts', 'ts.id_transaksi = jlb.id_transaksi')
            ->where('ts.status_transaksi', 'Lunas')
            ->where('DATE(ts.tanggal_masuk) >=', $tglMulai)
            ->where('DATE(ts.tanggal_masuk) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $operasional = $this->db->table('biaya_operasional')
            ->select('COALESCE(SUM(nominal),0) AS total', false)
            ->where('DATE(tanggal_biaya) >=', $tglMulai)
            ->where('DATE(tanggal_biaya) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $gaji = $this->db->table('gaji_harian_mekanik')
            ->select('COALESCE(SUM(nominal),0) AS total', false)
            ->where('DATE(tanggal_bayar) >=', $tglMulai)
            ->where('DATE(tanggal_bayar) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $pembelian = $this->db->table('pembelian_stok')
            ->select('COALESCE(SUM(total_biaya_pembelian),0) AS total', false)
            ->where('DATE(tanggal_pembelian) >=', $tglMulai)
            ->where('DATE(tanggal_pembelian) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $totalTransaksi = $this->db->table('transaksi_servis')
            ->where('status_transaksi', 'Lunas')
            ->where('DATE(tanggal_masuk) >=', $tglMulai)
            ->where('DATE(tanggal_masuk) <=', $tglSelesai)
            ->countAllResults();

        $omzet = $this->db->table('transaksi_servis')
            ->select('COALESCE(SUM(total_biaya),0) AS total', false)
            ->where('status_transaksi', 'Lunas')
            ->where('DATE(tanggal_masuk) >=', $tglMulai)
            ->where('DATE(tanggal_masuk) <=', $tglSelesai)
            ->get()
            ->getRow()->total ?? 0;

        $labaKotor = $labaJasa + $labaPart + $labaJasaLuar;
        $totalPengeluaran = $operasional + $gaji;
        $labaBersih = $labaKotor - $totalPengeluaran;

        return [
            'laba_jasa' => $labaJasa,
            'laba_part' => $labaPart,
            'laba_jasa_luar' => $labaJasaLuar,
            'laba_kotor' => $labaKotor,
            'biaya_operasional' => $operasional,
            'gaji_mekanik' => $gaji,
            'total_pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
            'pembelian' => $pembelian,
            'omzet' => $omzet,
            'total_transaksi' => $totalTransaksi,
        ];
    }

    public function getMetrikUmum()
    {
        $stokKritis = $this->db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        $transaksi_aktif = $this->db->table('transaksi_servis')
            ->whereIn('status_transaksi', [
                'Draft',
                'Progress'
            ])
            ->countAllResults();

        $asetGudang = $this->db->table('sparepart')
            ->select('COALESCE(SUM(stok_saat_ini * harga_modal),0) AS total', false)
            ->get()
            ->getRow()->total ?? 0;

        return [
            'stok_kritis' => $stokKritis,
            'transaksi_aktif' => $transaksi_aktif,
            'aset_gudang' => $asetGudang,
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
            ->get()
            ->getResultArray();
    }

    public function getMonitoringServis()
    {
        return $this->db->table('transaksi_servis')
            ->select('transaksi_servis.*, kendaraan.nomor_plat, pelanggan.nama_pelanggan, mekanik.nama_mekanik')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->whereIn('transaksi_servis.status_pengerjaan', [
                'Antre',
                'Diproses',
                'Menunggu Part'
            ])
            ->orderBy('transaksi_servis.tanggal_masuk', 'DESC')
            ->get()
            ->getResultArray();
    }
}