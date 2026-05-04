<?php namespace App\Models\Transaksi\Servis;
use CodeIgniter\Model;

class TransaksiServisModel extends Model {
    protected $table = 'transaksi_servis'; 
    protected $primaryKey = 'id_transaksi'; 
    protected $allowedFields = ['id_kendaraan', 'id_mekanik', 'id_pengguna', 'tanggal_masuk', 'keluhan_awal', 'hasil_pemeriksaan', 'status_pengerjaan', 'metode_pembayaran', 'status_pembayaran']; 
}