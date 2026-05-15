<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LoyalitasLaporanModel extends Model
{
    protected $table = 'view_laporan_loyalitas_pelanggan';
    protected $returnType = 'object';

    public function getLoyalitas($tglMulai, $tglAkhir)
    {
        return $this->table($this->table)
            ->select("
                kode_pelanggan,
                nama_pelanggan,
                COUNT(kode_transaksi) as frekuensi_servis,
                COALESCE(SUM(total_biaya), 0) as total_pengeluaran,
                CASE
                    WHEN COUNT(kode_transaksi) >= 10 THEN 'Sangat Loyal'
                    WHEN COUNT(kode_transaksi) >= 5 THEN 'Loyal'
                    ELSE 'Pelanggan Biasa'
                END as kategori_loyalitas
            ")
            ->where('tanggal_masuk >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_masuk <=', $tglAkhir . ' 23:59:59')
            ->groupBy('kode_pelanggan, nama_pelanggan')
            ->orderBy('frekuensi_servis', 'DESC')
            ->get()
            ->getResult();
    }
}