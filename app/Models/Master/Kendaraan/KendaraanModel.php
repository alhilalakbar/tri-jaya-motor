<?php namespace App\Models\Master\Kendaraan;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class KendaraanModel extends Model {
    use SearchableTrait;
    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    protected $allowedFields = ['id_pelanggan', 'id_tipe_motor', 'nomor_plat']; 
}