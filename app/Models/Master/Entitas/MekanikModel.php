<?php namespace App\Models\Master\Entitas;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class MekanikModel extends Model {
    use SearchableTrait;
    protected $table = 'mekanik'; 
    protected $primaryKey = 'id_mekanik'; 
    protected $allowedFields = ['nama_mekanik'];
}