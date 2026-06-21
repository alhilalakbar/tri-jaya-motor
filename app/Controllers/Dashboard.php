<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new DashboardModel();
        $periode = $this->request->getGet('periode') ?? 'harian';
        $tglInputMulai = $this->request->getGet('tgl_mulai');
        $tglInputSelesai = $this->request->getGet('tgl_selesai');

        if ($tglInputMulai && $tglInputSelesai) {
            $tanggalMulai = $tglInputMulai;
            $tanggalSelesai = $tglInputSelesai;
            $periode = 'custom';
        } else {
            if ($periode === 'bulanan') {
                $tanggalMulai = date('Y-m-01');
                $tanggalSelesai = date('Y-m-t');
            } else {
                $tanggalMulai = date('Y-m-d');
                $tanggalSelesai = date('Y-m-d');
            }
        }

        $keuangan = $model->getKeuanganMetrics($tanggalMulai, $tanggalSelesai);
        $umum = $model->getMetrikUmum();

        $labaBersih = $keuangan['laba_kotor'] - $keuangan['total_pengeluaran'];

        if ($labaBersih > 0) {
            $labaColor = 'success';
        } elseif ($labaBersih < 0) {
            $labaColor = 'danger';
        } else {
            $labaColor = 'secondary';
        }

        $data = [
            'title'             => 'Dashboard Bengkel',
            'periode'           => $periode,
            'tanggal_mulai'     => $tanggalMulai,
            'tanggal_selesai'   => $tanggalSelesai,
            'omzet'             => $keuangan['omzet'],
            'total_transaksi'   => $keuangan['total_transaksi'],
            'laba_kotor'        => $keuangan['laba_kotor'],
            'laba_bersih'       => $labaBersih,
            'laba_color'        => $labaColor,
            'total_pengeluaran' => $keuangan['total_pengeluaran'],
            'biaya_operasional' => $keuangan['biaya_operasional'],
            'gaji_mekanik'      => $keuangan['gaji_mekanik'],
            'pembelian'         => $keuangan['pembelian'],

            'belum_lunas'       => $umum['belum_lunas'],
            'stok_kritis'       => $umum['stok_kritis'],
            'aset_gudang'       => $umum['aset_gudang'],
            'unit_proses'       => $model->getMonitoringServis()        
            ];

        return view('dashboard', $data);
    }
}