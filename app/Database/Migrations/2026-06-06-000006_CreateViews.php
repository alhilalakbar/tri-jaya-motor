<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViews extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_laba_rugi AS 
            SELECT ts.kode_transaksi, ts.tanggal_masuk, ts.status_transaksi, ts.total_biaya, 
                   COALESCE(dpp.jumlah_pakai, 0) AS jumlah_pakai, COALESCE(s.harga_modal, 0) AS harga_modal, 
                   COALESCE((dpp.jumlah_pakai * s.harga_modal), 0) AS hpp_sparepart 
            FROM transaksi_servis ts 
            LEFT JOIN detail_penggunaan_part dpp ON ts.id_transaksi = dpp.id_transaksi 
            LEFT JOIN sparepart s ON dpp.id_part = s.id_part
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_loyalitas_pelanggan AS 
            SELECT ts.kode_transaksi, ts.tanggal_masuk, p.kode_pelanggan, p.nama_pelanggan, 
                   ts.total_biaya, ts.status_transaksi 
            FROM transaksi_servis ts 
            JOIN kendaraan k ON ts.id_kendaraan = k.id_kendaraan 
            JOIN pelanggan p ON k.id_pelanggan = p.id_pelanggan
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_pembelian_stok AS 
            SELECT ps.kode_pembelian, ps.tanggal_pembelian, pem.nama_pemasok, sp.nama_part, 
                   dps.jumlah_beli, dps.harga_beli_satuan, (dps.jumlah_beli * dps.harga_beli_satuan) AS subtotal, 
                   ps.total_biaya_pembelian 
            FROM pembelian_stok ps 
            JOIN pemasok pem ON ps.id_pemasok = pem.id_pemasok 
            JOIN detail_pembelian_stok dps ON ps.id_pembelian = dps.id_pembelian 
            JOIN sparepart sp ON dps.id_part = sp.id_part
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_pengeluaran AS 
            SELECT 'Biaya Operasional' AS jenis_pengeluaran, bo.tanggal_biaya AS tanggal, bo.nominal, bo.keterangan, kbo.nama_kategori 
            FROM biaya_operasional bo 
            JOIN kategori_biaya_operasional kbo ON bo.id_kategori_biaya = kbo.id_kategori_biaya 
            UNION ALL 
            SELECT 'Gaji Mekanik' AS jenis_pengeluaran, ghm.tanggal_bayar AS tanggal, ghm.nominal, ghm.keterangan, m.nama_mekanik 
            FROM gaji_harian_mekanik ghm 
            JOIN mekanik m ON ghm.id_mekanik = m.id_mekanik
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_performa_mekanik AS 
            SELECT ts.kode_transaksi, ts.tanggal_masuk, m.kode_mekanik, m.nama_mekanik, 
                   djs.harga_saat_transaksi, djs.biaya_tambahan 
            FROM transaksi_servis ts 
            JOIN mekanik m ON ts.id_mekanik = m.id_mekanik 
            LEFT JOIN detail_jasa_servis djs ON ts.id_transaksi = djs.id_transaksi
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_stok_sparepart AS 
            SELECT sp.kode_part, sp.nama_part, kp.nama_kategori, mp.nama_merek_part, sp.kualitas_part, 
                   sp.harga_jual, sp.stok_saat_ini, sp.stok_minimum, 
                   (CASE WHEN sp.stok_saat_ini <= sp.stok_minimum THEN 'Stok Kritis' ELSE 'Aman' END) AS status_stok 
            FROM sparepart sp 
            JOIN kategori_part kp ON sp.id_kategori = kp.id_kategori 
            JOIN merek_part mp ON sp.id_merek_part = mp.id_merek_part
        ");

        $this->db->query("
            CREATE OR REPLACE VIEW view_laporan_transaksi_servis AS 
            SELECT ts.kode_transaksi, ts.tanggal_masuk, p.nama_pelanggan, k.nomor_plat, mm.nama_merek_motor, 
                   tm.nama_tipe, m.nama_mekanik, ts.status_pengerjaan, ts.status_transaksi, ts.metode_pembayaran, ts.total_biaya 
            FROM transaksi_servis ts 
            JOIN kendaraan k ON ts.id_kendaraan = k.id_kendaraan 
            JOIN pelanggan p ON k.id_pelanggan = p.id_pelanggan 
            JOIN tipe_motor tm ON k.id_tipe_motor = tm.id_tipe_motor 
            JOIN merek_motor mm ON tm.id_merek_motor = mm.id_merek_motor 
            JOIN mekanik m ON ts.id_mekanik = m.id_mekanik
        ");
    }

    public function down()
    {
        $this->db->query("DROP VIEW IF EXISTS view_laporan_laba_rugi");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_loyalitas_pelanggan");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_pembelian_stok");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_pengeluaran");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_performa_mekanik");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_stok_sparepart");
        $this->db->query("DROP VIEW IF EXISTS view_laporan_transaksi_servis");
    }
}