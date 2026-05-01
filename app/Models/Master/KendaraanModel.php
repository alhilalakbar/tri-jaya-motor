<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class KendaraanModel extends Model
{
protected $table            = 'kendaraan'; 
protected $primaryKey       = 'id_kendaraan'; 
protected $allowedFields    = ['id_pelanggan', 'id_tipe_motor', 'nomor_plat'];
}
