<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class MerekPartModel extends Model
{
    protected $table            = 'merek_part';
    protected $primaryKey       = 'id_merek_part';
    protected $allowedFields    = ['nama_merek'];
}