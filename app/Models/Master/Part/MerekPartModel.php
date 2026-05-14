<?php namespace App\Models\Master\Part;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class MerekPartModel extends Model {
    use SearchableTrait;
    protected $table = 'merek_part'; 
    protected $primaryKey = 'id_merek_part'; 
    protected $allowedFields = ['nama_merek_part']; 
}