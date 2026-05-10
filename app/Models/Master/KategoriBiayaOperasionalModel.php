<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class KategoriBiayaOperasionalModel extends Model
{
    protected $table = 'kategori_biaya_operasional';

    protected $primaryKey = 'id_kategori_biaya';

    protected $allowedFields = [
        'nama_kategori'
    ];

    protected $useTimestamps = false;
}