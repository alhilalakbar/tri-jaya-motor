<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class PerformaMekanikLaporanModel extends Model
{
    protected $table = 'view_laporan_performa_mekanik';
    protected $returnType = 'object';

    public function getPerformaMekanik($tglMulai, $tglAkhir)
    {
        return $this->table($this->table)
            ->select("
                kode_mekanik,
                nama_mekanik,
                COUNT(DISTINCT kode_transaksi) as total_servis,
                COALESCE(SUM(harga_saat_transaksi + biaya_tambahan), 0) as total_pendapatan_jasa
            ")
            ->where('tanggal_masuk >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_masuk <=', $tglAkhir . ' 23:59:59')
            ->groupBy('kode_mekanik, nama_mekanik')
            ->orderBy('total_servis', 'DESC')
            ->get()
            ->getResult();
    }
}