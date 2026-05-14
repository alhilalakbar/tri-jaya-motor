<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class PenggunaModel extends Model {
    use SearchableTrait;
    protected $table = 'pengguna'; 
    protected $primaryKey = 'id_pengguna'; 
    protected $allowedFields = ['nama_pengguna', 'kata_sandi', 'peran']; 
}