<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data = [
            'title' => 'Dashboard Bengkel',
            'pendapatan_harian' => $db->table('view_laporan_pendapatan')->get()->getResultArray(),
            'total_antrean' => $db->table('transaksi_servis')->where('status_pengerjaan', 'Antre')->countAllResults()
        ];

        return view('dashboard/index', $data);
    }
}
