<?php namespace App\Models\Transaksi\Stok;
use CodeIgniter\Model;

class DetailPembelianModel extends Model {
    protected $table = 'detail_pembelian_stok'; 
    protected $primaryKey = 'id_detail_pembelian'; 
    protected $allowedFields = ['id_pembelian', 'id_part', 'jumlah_beli', 'harga_beli_satuan']; 
}