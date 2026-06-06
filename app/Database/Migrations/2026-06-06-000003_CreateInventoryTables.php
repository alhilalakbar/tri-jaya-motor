<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_part'       => ['type' => 'INT', 'auto_increment' => true],
            'kode_part'     => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'id_kategori'   => ['type' => 'INT'],
            'id_merek_part' => ['type' => 'INT', 'null' => true],
            'nama_part'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'kualitas_part' => ['type' => 'ENUM("Original","OEM","KW")', 'default' => 'Original'],
            'harga_modal'   => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'harga_jual'    => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'stok_saat_ini' => ['type' => 'INT', 'default' => 0],
            'stok_minimum'  => ['type' => 'INT', 'default' => 5],
        ]);
        $this->forge->addKey('id_part', true);
        $this->forge->addUniqueKey('kode_part');
        $this->forge->addUniqueKey('nama_part');
        $this->forge->addForeignKey('id_kategori', 'kategori_part', 'id_kategori', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_merek_part', 'merek_part', 'id_merek_part', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('sparepart');

        $this->forge->addField([
            'id_pembelian'          => ['type' => 'INT', 'auto_increment' => true],
            'kode_pembelian'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'id_pemasok'            => ['type' => 'INT', 'null' => true],
            'id_pengguna'           => ['type' => 'INT', 'null' => true],
            'tanggal_pembelian'     => ['type' => 'DATETIME', 'null' => true],
            'total_biaya_pembelian' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
        ]);
        $this->forge->addKey('id_pembelian', true);
        $this->forge->addUniqueKey('kode_pembelian');
        $this->forge->addForeignKey('id_pemasok', 'pemasok', 'id_pemasok', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('pembelian_stok');

        $this->forge->addField([
            'id_detail_pembelian' => ['type' => 'INT', 'auto_increment' => true],
            'id_pembelian'        => ['type' => 'INT', 'null' => true],
            'id_part'             => ['type' => 'INT', 'null' => true],
            'jumlah_beli'         => ['type' => 'INT'],
            'harga_beli_satuan'   => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
        ]);
        $this->forge->addKey('id_detail_pembelian', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian_stok', 'id_pembelian', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_part', 'sparepart', 'id_part', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('detail_pembelian_stok');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pembelian_stok');
        $this->forge->dropTable('pembelian_stok');
        $this->forge->dropTable('sparepart');
    }
}