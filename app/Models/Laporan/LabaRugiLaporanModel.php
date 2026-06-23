<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LabaRugiLaporanModel extends Model
{

    protected $table = 'transaksi_servis';
    protected $returnType = 'object';

    public function getLabaRugi($tglMulai, $tglAkhir)
    {
        $db = \Config\Database::connect();


        $pendapatan = $db->table('transaksi_servis')
            ->select('COALESCE(SUM(total_biaya), 0) AS total_pendapatan')
            ->where('status_pembayaran', 'Lunas')
            ->where('tanggal_masuk >=', $tglMulai . ' 00:00:00')
            ->where('tanggal_masuk <=', $tglAkhir . ' 23:59:59')
            ->get()
            ->getRow();


        $hpp = $db->table('detail_penggunaan_part')
            ->select('COALESCE(SUM(detail_penggunaan_part.jumlah_pakai * detail_penggunaan_part.harga_satuan_modal), 0) AS total_hpp')
            ->join('transaksi_servis', 'transaksi_servis.id_transaksi = detail_penggunaan_part.id_transaksi')
            ->where('transaksi_servis.status_pembayaran', 'Lunas')
            ->where('transaksi_servis.tanggal_masuk >=', $tglMulai . ' 00:00:00')
            ->where('transaksi_servis.tanggal_masuk <=', $tglAkhir . ' 23:59:59')
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
        $result->total_pendapatan  = $pendapatan->total_pendapatan;
        $result->total_hpp         = $hpp->total_hpp;
        $result->total_operasional = $operasional->total_operasional;
        $result->total_gaji        = $gaji->total_gaji;
        
        $result->estimasi_laba_bersih = 
            $result->total_pendapatan 
            - $result->total_hpp 
            - $result->total_operasional 
            - $result->total_gaji;

        return $result;
    }
}