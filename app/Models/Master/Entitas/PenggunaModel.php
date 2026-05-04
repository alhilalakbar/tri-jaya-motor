<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;

class PenggunaModel extends Model {
    protected $table = 'pengguna'; 
    protected $primaryKey = 'id_pengguna'; 
    protected $allowedFields = ['nama_pengguna', 'kata_sandi', 'peran']; 
}