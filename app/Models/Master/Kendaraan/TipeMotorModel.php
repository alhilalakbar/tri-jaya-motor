<?php namespace App\Models\Master\Kendaraan;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class TipeMotorModel extends Model {
    use SearchableTrait;
    protected $table = 'tipe_motor'; 
    protected $primaryKey = 'id_tipe_motor'; 
    protected $allowedFields = ['id_merek_motor', 'nama_tipe', 'jenis_kendaraan']; 
}