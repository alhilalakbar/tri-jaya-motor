<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class GajiMekanikModel extends Model
{
    protected $table = 'gaji_harian_mekanik';
    protected $primaryKey = 'id_gaji';

    protected $allowedFields = [
        'id_mekanik',
        'id_pengguna',
        'tanggal_bayar',
        'nominal',
        'keterangan'
    ];

    protected $useTimestamps = false;
}