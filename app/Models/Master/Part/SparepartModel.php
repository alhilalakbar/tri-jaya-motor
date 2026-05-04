<?php namespace App\Models\Master\Part;
use CodeIgniter\Model;

class SparepartModel extends Model {
    protected $table = 'sparepart'; 
    protected $primaryKey = 'id_part'; 
    protected $allowedFields = ['id_kategori', 'id_merek_part', 'nama_part', 'kualitas_part', 'harga_modal', 'harga_jual', 'stok_saat_ini', 'stok_minimum']; 
}