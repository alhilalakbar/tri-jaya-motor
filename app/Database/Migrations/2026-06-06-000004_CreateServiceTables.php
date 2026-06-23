<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServiceTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'      => ['type' => 'INT', 'auto_increment' => true],
            'kode_transaksi'    => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_kendaraan'      => ['type' => 'INT'],
            'id_mekanik'        => ['type' => 'INT', 'null' => true],
            'id_pengguna'       => ['type' => 'INT', 'null' => true],
            'tanggal_masuk'     => ['type' => 'DATETIME', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'keluhan_awal'      => ['type' => 'TEXT', 'null' => true],
            'hasil_pemeriksaan' => ['type' => 'TEXT', 'null' => true],
            'status_pengerjaan' => ['type' => 'ENUM("Antre","Diproses","Menunggu Part","Selesai","Diambil","Dibatalkan")', 'null' => true],
            'status_transaksi'  => ['type' => 'ENUM("Draft","Progress","Lunas")', 'default' => 'Draft'],            
            'metode_pembayaran' => ['type' => 'ENUM("Tunai","QRIS","BRI","Dana")', 'default' => 'Tunai'],
            'status_pembayaran' => ['type' => 'ENUM("Lunas","Belum Lunas")', 'default' => 'Belum Lunas'],
            'total_biaya'       => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
        ]);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addUniqueKey('kode_transaksi');
        $this->forge->addForeignKey('id_kendaraan', 'kendaraan', 'id_kendaraan', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_mekanik', 'mekanik', 'id_mekanik', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('transaksi_servis');
        $this->forge->addField([
            'id_detail_part'     => ['type' => 'INT', 'auto_increment' => true],
            'id_transaksi'       => ['type' => 'INT'],
            'id_part'            => ['type' => 'INT'],
            'jumlah_pakai'       => ['type' => 'INT'],            
            'harga_satuan_modal' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'harga_satuan_jual'  => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'subtotal'           => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
        ]);
        $this->forge->addKey('id_detail_part', true);
        $this->forge->addUniqueKey(['id_transaksi', 'id_part'], 'unique_part_per_transaksi');
        $this->forge->addForeignKey('id_transaksi', 'transaksi_servis', 'id_transaksi', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_part', 'sparepart', 'id_part', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('detail_penggunaan_part');
        $this->forge->addField([
            'id_detail_jasa'       => ['type' => 'INT', 'auto_increment' => true],
            'id_transaksi'         => ['type' => 'INT'],
            'id_jasa'              => ['type' => 'INT'],
            'harga_saat_transaksi' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'biaya_tambahan'       => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
        ]);
        $this->forge->addKey('id_detail_jasa', true);
        $this->forge->addUniqueKey(['id_transaksi', 'id_jasa'], 'unique_jasa_per_transaksi');
        $this->forge->addForeignKey('id_transaksi', 'transaksi_servis', 'id_transaksi', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_jasa', 'jasa_servis', 'id_jasa', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('detail_jasa_servis');
        $this->forge->addField([
            'id_jasa_luar'         => ['type' => 'INT', 'auto_increment' => true],
            'kode_jasa_luar'       => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'id_transaksi'         => ['type' => 'INT', 'null' => true],
            'deskripsi_pekerjaan'  => ['type' => 'TEXT', 'null' => true],
            'biaya_modal_vendor'   => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'tagihan_ke_pelanggan' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
        ]);
        $this->forge->addKey('id_jasa_luar', true);
        $this->forge->addUniqueKey('kode_jasa_luar');
        $this->forge->addForeignKey('id_transaksi', 'transaksi_servis', 'id_transaksi', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('jasa_luar_bubut');
    }

    public function down()
    {
        $this->forge->dropTable('jasa_luar_bubut');
        $this->forge->dropTable('detail_jasa_servis');
        $this->forge->dropTable('detail_penggunaan_part');
        $this->forge->dropTable('transaksi_servis');
    }
}