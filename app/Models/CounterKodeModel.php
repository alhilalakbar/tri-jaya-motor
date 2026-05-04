<?php namespace App\Models;
use CodeIgniter\Model;

class CounterKodeModel extends Model {
    protected $table = 'counter_kode';
    protected $primaryKey = 'nama_counter';
    protected $allowedFields = ['counter_value'];
}