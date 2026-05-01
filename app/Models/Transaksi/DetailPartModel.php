<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class DetailPartModel extends Model
{
    protected $table = 'detail_penggunaan_part';
    protected $primaryKey = 'id_detail_part';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_transaksi',
        'id_part',
        'jumlah_pakai',
        'harga_satuan_jual'
    ];
}
