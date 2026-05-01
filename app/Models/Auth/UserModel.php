<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'pengguna'; 
    protected $primaryKey = 'id_pengguna'; 
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_pengguna', 'kata_sandi', 'peran']; 
}
