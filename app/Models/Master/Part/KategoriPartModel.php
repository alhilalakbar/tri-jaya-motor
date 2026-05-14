<?php namespace App\Models\Master\Part;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class KategoriPartModel extends Model {
    use SearchableTrait;
    protected $table = 'kategori_part';     
    protected $primaryKey = 'id_kategori'; 
    protected $allowedFields = ['nama_kategori']; 
}