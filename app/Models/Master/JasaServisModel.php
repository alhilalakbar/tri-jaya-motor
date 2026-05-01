<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class JasaServisModel extends Model
{
protected $table            = 'jasa_servis';
protected $primaryKey       = 'id_jasa'; 
protected $allowedFields    = ['nama_jasa', 'biaya_standar']; 
}
