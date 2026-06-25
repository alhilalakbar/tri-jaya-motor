<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CounterKodeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_counter' => 'jasa_luar', 'counter_value' => 0],
            ['nama_counter' => 'jasa', 'counter_value' => 0],
            ['nama_counter' => 'kategori_part', 'counter_value' => 0],
            ['nama_counter' => 'kendaraan', 'counter_value' => 0],
            ['nama_counter' => 'mekanik', 'counter_value' => 0],
            ['nama_counter' => 'merek_motor', 'counter_value' => 0],
            ['nama_counter' => 'merek_part', 'counter_value' => 0],
            ['nama_counter' => 'pelanggan', 'counter_value' => 0],
            ['nama_counter' => 'pemasok', 'counter_value' => 0],
            ['nama_counter' => 'pembelian', 'counter_value' => 0],
            ['nama_counter' => 'pengguna', 'counter_value' => 0],
            ['nama_counter' => 'sparepart', 'counter_value' => 0],
            ['nama_counter' => 'tipe_motor', 'counter_value' => 0],
            ['nama_counter' => 'transaksi', 'counter_value' => 0],
        ];

        $this->db->table('counter_kode')->insertBatch($data);
    }
}