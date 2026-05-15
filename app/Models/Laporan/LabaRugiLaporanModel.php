<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LabaRugiLaporanModel extends Model
{
    protected $table = 'view_laporan_laba_rugi';
    protected $returnType = 'object';

    public function getLabaRugi($tglMulai, $tglAkhir)
    {
        $db = \Config\Database::connect();

        $laporan = $this->table($this->table)
            ->select("
                COALESCE(SUM(
                    CASE
                        WHEN status_pembayaran = 'Lunas'
                        THEN total_biaya
                        ELSE 0
                    END
                ), 0) AS total_pendapatan,

                COALESCE(SUM(
                    CASE
                        WHEN status_pembayaran = 'Lunas'
                        THEN hpp_sparepart
                        ELSE 0
                    END
                ), 0) AS total_hpp
            ")
            ->where('tanggal_masuk >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_masuk <=', $tglAkhir . ' 23:59:59')
            ->get()
            ->getRow();

        $operasional = $db->table('biaya_operasional')
            ->select('COALESCE(SUM(nominal), 0) AS total_operasional')
            ->where('tanggal_biaya >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_biaya <=', $tglAkhir . ' 23:59:59')
            ->get()
            ->getRow();

        $gaji = $db->table('gaji_harian_mekanik')
            ->select('COALESCE(SUM(nominal), 0) AS total_gaji')
            ->where('tanggal_bayar >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_bayar <=', $tglAkhir . ' 23:59:59')
            ->get()
            ->getRow();

        $result = new \stdClass();
        $result->total_pendapatan = $laporan->total_pendapatan;
        $result->total_hpp = $laporan->total_hpp;
        $result->total_operasional = $operasional->total_operasional;
        $result->total_gaji = $gaji->total_gaji;
        $result->estimasi_laba_bersih =
            $result->total_pendapatan
            - $result->total_hpp
            - $result->total_operasional
            - $result->total_gaji;

        return $result;
    }
}