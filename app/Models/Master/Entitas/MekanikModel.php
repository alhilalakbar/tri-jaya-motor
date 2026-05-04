<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;

class MekanikModel extends Model {
    protected $table = 'mekanik'; 
    protected $primaryKey = 'id_mekanik'; 
    protected $allowedFields = ['nama_mekanik'];
}