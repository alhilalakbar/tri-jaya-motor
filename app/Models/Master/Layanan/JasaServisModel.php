<?php namespace App\Models\Master\Layanan;
use CodeIgniter\Model;
use App\Models\SearchableTrait;
class JasaServisModel extends Model {
    use SearchableTrait;
    protected $table = 'jasa_servis'; 
    protected $primaryKey = 'id_jasa'; 
    protected $allowedFields = ['nama_jasa', 'biaya_standar']; 
}