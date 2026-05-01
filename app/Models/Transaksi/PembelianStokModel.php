<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class PembelianStokModel extends Model
{
    protected $table            = 'pembelian_stok';
    protected $primaryKey       = 'id_pembelian';
    protected $allowedFields    = ['id_pemasok', 'id_pengguna', 'tanggal_pembelian', 'total_biaya_pembelian'];
}