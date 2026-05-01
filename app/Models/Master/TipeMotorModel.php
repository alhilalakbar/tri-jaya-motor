<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class TipeMotorModel extends Model
{
    protected $table            = 'tipe_motor';
    protected $primaryKey       = 'id_tipe_motor';
    protected $allowedFields    = ['id_merek_motor', 'nama_tipe', 'jenis_kendaraan'];
}