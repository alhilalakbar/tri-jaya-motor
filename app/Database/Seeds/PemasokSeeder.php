<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemasokSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        $db->disableForeignKeyChecks();
        $db->table('pemasok')->truncate();
        $db->enableForeignKeyChecks();

        $pemasok = [
            [
                'nama_pemasok' => 'Astra Komponen Indonesia PT',
                'nomor_hp_pemasok' => '0216511518', // [cite: 6]
                'alamat_pemasok' => 'Jl. Gaya Motor Brt 2, Sungai Bambu, Tanjung Priok 14330' 
            ],
            [
                'nama_pemasok' => 'Rachmat Perdana Adimetal PT',
                'nomor_hp_pemasok' => '02146827159', // [cite: 25]
                'alamat_pemasok' => 'Kawasan Industri Pulogadung BI D/12 Jatinegara, Cakung 13930' 
            ],
            [
                'nama_pemasok' => 'AMX Motor Indonesia PT',
                'nomor_hp_pemasok' => '02188984129', // [cite: 48]
                'alamat_pemasok' => 'Jl. Raya Kaliabang RT 003/02 Harapan Jaya, Bekasi Utara 17124' 
            ],
            [
                'nama_pemasok' => 'Sumber Usaha',
                'nomor_hp_pemasok' => '0218715056', // [cite: 1211]
                'alamat_pemasok' => 'Jl. Raya Bogor Km 27 16 Pekayon, Pasar Rebo, Jakarta Timur 13710' 
            ],
            [
                'nama_pemasok' => 'Showa Indonesia Mfg PT',
                'nomor_hp_pemasok' => '02165311155', // [cite: 117]
                'alamat_pemasok' => 'Graha Kirana, Jl. Kom L Yos Sudarso Kav 88 Sunter Agung, Tanjung Priok 14350' 
            ]
        ];

        $this->db->table('pemasok')->insertBatch($pemasok);
    }
}