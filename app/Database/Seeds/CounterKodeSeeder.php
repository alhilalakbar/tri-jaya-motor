<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CounterKodeSeeder extends Seeder
{
    public function run()
    {
        $this->db->query(<<<'SQL'
INSERT INTO `counter_kode` (`nama_counter`, `counter_value`) VALUES
('jasa', 0),
('jasa_luar', 0),
('kategori_part', 0),
('kendaraan', 0),
('mekanik', 0),
('merek_motor', 0),
('merek_part', 0),
('pelanggan', 0),
('pemasok', 0),
('pembelian', 0),
('pengguna', 0),
('sparepart', 0),
('tipe_motor', 0),
('transaksi', 0);
SQL);
    }
}
