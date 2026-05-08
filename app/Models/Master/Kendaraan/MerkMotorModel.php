<?php namespace App\Models\Master\Kendaraan;
use CodeIgniter\Model;

class MerkMotorModel extends Model {
    protected $table = 'merek_motor'; 
    protected $primaryKey = 'id_merek_motor'; 
    protected $allowedFields = ['nama_merek_motor']; 
}