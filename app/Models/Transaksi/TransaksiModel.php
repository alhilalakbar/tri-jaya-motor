<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi_servis';
    protected $primaryKey = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_kendaraan',
        'id_mekanik',
        'id_pengguna',
        'tanggal_masuk',
        'keluhan_awal',
        'hasil_pemeriksaan',
        'status_pengerjaan',
        'metode_pembayaran',
        'status_pembayaran'
    ];

    public function getDetailTransaksi()
    {
        return $this->db->table('view_laporan_transaksi')->get()->getResultArray();
    }
}