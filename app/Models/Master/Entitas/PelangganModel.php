<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class PelangganModel extends Model {
    use SearchableTrait;
    protected $table = 'pelanggan'; 
    protected $primaryKey = 'id_pelanggan'; 
    protected $allowedFields = ['nama_pelanggan', 'nomor_hp']; 
}