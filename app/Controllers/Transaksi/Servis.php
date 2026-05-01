<?php

namespace App\Controllers;

use App\Models\Transaksi\TransaksiModel;

class Servis extends BaseController
{
    public function index()
    {
        $transaksiModel = new TransaksiModel();
        $data = [
            'title'  => 'Daftar Servis',
            'servis' => $transaksiModel->getDetailTransaksi()
        ];

        return view('transaksi/servis/index', $data);
    }
}
