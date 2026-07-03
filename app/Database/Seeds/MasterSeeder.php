<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        $db->disableForeignKeyChecks();
        
        $db->table('merek_motor')->truncate();
        $db->table('tipe_motor')->truncate();
        $db->table('kategori_part')->truncate();
        $db->table('merek_part')->truncate();
        $db->table('sparepart')->truncate();
        $db->table('pelanggan')->truncate();
        $db->table('kendaraan')->truncate();
        $db->table('mekanik')->truncate();
        $db->table('jasa_servis')->truncate();
        $db->table('kategori_biaya_operasional')->truncate();
        
        $db->enableForeignKeyChecks();

        $merekMotor = [
            ['id_merek_motor' => 1, 'nama_merek_motor' => 'Yamaha'],
            ['id_merek_motor' => 2, 'nama_merek_motor' => 'Honda']
        ];
        $this->db->table('merek_motor')->insertBatch($merekMotor);

        $tipeMotor = [
            ['id_tipe_motor' => 1, 'id_merek_motor' => 1, 'nama_tipe' => 'Jupiter Z', 'jenis_kendaraan' => 'Bebek'],
            ['id_tipe_motor' => 2, 'id_merek_motor' => 1, 'nama_tipe' => 'Vixion', 'jenis_kendaraan' => 'Sport'],
            ['id_tipe_motor' => 3, 'id_merek_motor' => 2, 'nama_tipe' => 'Verza', 'jenis_kendaraan' => 'Sport']
        ];
        $this->db->table('tipe_motor')->insertBatch($tipeMotor);

        $mekanik = [
            ['nama_mekanik' => 'Azry Muhammad Syawal'],
            ['nama_mekanik' => 'Nasrul Ulum']
        ];
        $this->db->table('mekanik')->insertBatch($mekanik);

        $pelanggan = [
            ['id_pelanggan' => 1, 'nama_pelanggan' => 'Edwin van der Sar', 'nomor_hp' => '081100000001'],
            ['id_pelanggan' => 2, 'nama_pelanggan' => 'Wes Brown', 'nomor_hp' => '081100000002'],
            ['id_pelanggan' => 3, 'nama_pelanggan' => 'Rio Ferdinand', 'nomor_hp' => '081100000003'],
            ['id_pelanggan' => 4, 'nama_pelanggan' => 'Nemanja Vidić', 'nomor_hp' => '081100000004'],
            ['id_pelanggan' => 5, 'nama_pelanggan' => 'Patrice Evra', 'nomor_hp' => '081100000005'],
            ['id_pelanggan' => 6, 'nama_pelanggan' => 'Owen Hargreaves', 'nomor_hp' => '081100000006'],
            ['id_pelanggan' => 7, 'nama_pelanggan' => 'Paul Scholes', 'nomor_hp' => '081100000007'],
            ['id_pelanggan' => 8, 'nama_pelanggan' => 'Michael Carrick', 'nomor_hp' => '081100000008'],
            ['id_pelanggan' => 9, 'nama_pelanggan' => 'Cristiano Ronaldo', 'nomor_hp' => '081100000009'],
            ['id_pelanggan' => 10, 'nama_pelanggan' => 'Wayne Rooney', 'nomor_hp' => '081100000010'],
            ['id_pelanggan' => 11, 'nama_pelanggan' => 'Carlos Tévez', 'nomor_hp' => '081100000011'],
        ];
        $this->db->table('pelanggan')->insertBatch($pelanggan);

        $kendaraan = [
            ['id_kendaraan' => 1, 'id_pelanggan' => 9, 'id_tipe_motor' => 2, 'nomor_plat' => 'B 777 CR'],
            ['id_kendaraan' => 2, 'id_pelanggan' => 10, 'id_tipe_motor' => 1, 'nomor_plat' => 'B 1010 WR'], 
            ['id_kendaraan' => 3, 'id_pelanggan' => 11, 'id_tipe_motor' => 3, 'nomor_plat' => 'B 3232 CT'], 
        ];
        $this->db->table('kendaraan')->insertBatch($kendaraan);

        $kategoriPart = [
            ['id_kategori' => 1, 'nama_kategori' => 'Oli Mesin'],
            ['id_kategori' => 2, 'nama_kategori' => 'Kampas Rem']
        ];
        $this->db->table('kategori_part')->insertBatch($kategoriPart);

        $merekPart = [
            ['id_merek_part' => 1, 'nama_merek_part' => 'Yamalube'],
            ['id_merek_part' => 2, 'nama_merek_part' => 'Motul'],
            ['id_merek_part' => 3, 'nama_merek_part' => 'AHM']
        ];
        $this->db->table('merek_part')->insertBatch($merekPart);

        $sparepart = [
            [
                'id_kategori' => 1,
                'id_merek_part' => 1,
                'nama_part' => 'Yamalube Power Matic 10W-40 0.8L',
                'kualitas_part' => 'Original',
                'harga_jual' => 77200,
                'stok_saat_ini' => 0,
                'stok_minimum' => 5
            ],
            [
                'id_kategori' => 1,
                'id_merek_part' => 2,
                'nama_part' => 'Motul 5100 4T 10W40 1L Technosynthese Ester',
                'kualitas_part' => 'Original',
                'harga_jual' => 169300,
                'stok_saat_ini' => 0,
                'stok_minimum' => 5
            ],
            [
                'id_kategori' => 1,
                'id_merek_part' => 3,
                'nama_part' => 'AHM Oil MPX-1 0.8L 10W-30',
                'kualitas_part' => 'Original',
                'harga_jual' => 56000,
                'stok_saat_ini' => 0,
                'stok_minimum' => 5
            ]
        ];
        $this->db->table('sparepart')->insertBatch($sparepart);

        $jasaServis = [
            ['nama_jasa' => 'Servis Ringan', 'biaya_standar' => 50000],
            ['nama_jasa' => 'Ganti Oli', 'biaya_standar' => 15000],
            ['nama_jasa' => 'Ubah Kopling Manual', 'biaya_standar' => 150000]
        ];
        $this->db->table('jasa_servis')->insertBatch($jasaServis);

        $kategoriBiaya = [
            ['nama_kategori' => 'Listrik & Air'],
            ['nama_kategori' => 'Konsumsi Bengkel'],
            ['nama_kategori' => 'Alat Tulis & Nota']
        ];
        $this->db->table('kategori_biaya_operasional')->insertBatch($kategoriBiaya);
    }
}