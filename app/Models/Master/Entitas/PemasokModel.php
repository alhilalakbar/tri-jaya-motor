<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class PemasokModel extends Model {
    use SearchableTrait;
    protected $table = 'pemasok'; 
    protected $primaryKey = 'id_pemasok'; 
    protected $allowedFields = ['nama_pemasok', 'nomor_hp_pemasok', 'alamat_pemasok']; 
}