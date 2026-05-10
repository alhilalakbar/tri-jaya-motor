<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class BiayaOperasionalModel extends Model
{
    protected $table = 'biaya_operasional';

    protected $primaryKey = 'id_biaya_operasional';

    protected $allowedFields = [

        'id_kategori_biaya',
        'id_pengguna',
        'tanggal_biaya',
        'nominal',
        'keterangan',
    ];

    protected $useTimestamps = false;
}