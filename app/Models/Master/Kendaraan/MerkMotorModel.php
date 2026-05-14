<?php namespace App\Models\Master\Kendaraan;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class MerkMotorModel extends Model {
    use SearchableTrait;
    protected $table = 'merek_motor'; 
    protected $primaryKey = 'id_merek_motor'; 
    protected $allowedFields = ['nama_merek_motor']; 
}