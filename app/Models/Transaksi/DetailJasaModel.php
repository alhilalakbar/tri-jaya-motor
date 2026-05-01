<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class DetailJasaModel extends Model
{
    protected $table = 'detail_jasa_servis';
    protected $primaryKey = 'id_detail_jasa';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_transaksi',
        'id_jasa',
        'harga_saat_transaksi',
        'biaya_tambahan'
    ];
}