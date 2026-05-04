<?php namespace App\Models\Transaksi\Servis;
use CodeIgniter\Model;

class JasaLuarModel extends Model {
    protected $table = 'jasa_luar_bubut'; 
    protected $primaryKey = 'id_jasa_luar'; 
    protected $allowedFields = ['id_transaksi', 'deskripsi_pekerjaan', 'biaya_modal_vendor', 'tagihan_ke_pelanggan']; 
}