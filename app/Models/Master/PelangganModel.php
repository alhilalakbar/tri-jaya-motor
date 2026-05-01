<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class PelangganModel extends Model
{
protected $table            = 'pelanggan';
protected $primaryKey       = 'id_pelanggan'; 
protected $allowedFields    = ['nama_pelanggan', 'nomor_hp'];
}
