<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class PemasokModel extends Model
{
    protected $table            = 'pemasok';
    protected $primaryKey       = 'id_pemasok';
    protected $allowedFields    = ['nama_pemasok', 'nomor_hp_pemasok', 'alamat_pemasok'];
}