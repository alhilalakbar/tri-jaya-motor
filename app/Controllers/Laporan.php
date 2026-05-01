<?php

namespace App\Controllers;

class Laporan extends BaseController
{

    /** @var \CodeIgniter\Database\BaseConnection */
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('laporan/index', ['title' => 'Menu Laporan']);
    }

    public function stok()
    {
        $data = [
            'title' => 'Laporan Stok Sparepart',
            'stok' => $this->db->table('view_laporan_stok')->get()->getResultArray()
        ];
        return view('laporan/stok', $data);
    }

    public function transaksi()
    {
        $data = [
            'title' => 'Laporan Transaksi Servis',
            'transaksi' => $this->db->table('view_laporan_transaksi')->get()->getResultArray()
        ];
        return view('laporan/transaksi', $data);
    }

    public function pendapatan()
    {
        $data = [
            'title' => 'Laporan Pendapatan',
            'pendapatan' => $this->db->table('view_laporan_pendapatan')->get()->getResultArray()
        ];
        return view('laporan/pendapatan', $data);
    }

    public function jasaLuar()
    {
        $data = [
            'title' => 'Laporan Jasa Luar/Bubut',
            'jasaluar' => $this->db->table('view_laporan_jasa_luar')->get()->getResultArray()
        ];
        return view('laporan/jasa_luar', $data);
    }
}