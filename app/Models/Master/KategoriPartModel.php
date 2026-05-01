<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class KategoriPartModel extends Model
{
    protected $table            = 'kategori_part';
    protected $primaryKey       = 'id_kategori';
    protected $allowedFields    = ['nama_kategori'];
}