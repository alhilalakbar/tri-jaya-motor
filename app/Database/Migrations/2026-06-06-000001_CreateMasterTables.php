<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nama_counter'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'counter_value' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('nama_counter', true);
        $this->forge->createTable('counter_kode');

        $this->forge->addField([
            'id_kategori_biaya' => ['type' => 'INT', 'auto_increment' => true],
            'nama_kategori'     => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_kategori_biaya', true);
        $this->forge->createTable('kategori_biaya_operasional');

        $this->forge->addField([
            'id_kategori'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_kategori' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id_kategori', true);
        $this->forge->addUniqueKey('kode_kategori');
        $this->forge->createTable('kategori_part');

        $this->forge->addField([
            'id_merek_part'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_merek_part' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_merek_part' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id_merek_part', true);
        $this->forge->addUniqueKey('kode_merek_part');
        $this->forge->addUniqueKey('nama_merek_part');
        $this->forge->createTable('merek_part');

        $this->forge->addField([
            'id_merek_motor'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_merek_motor' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_merek_motor' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addKey('id_merek_motor', true);
        $this->forge->addUniqueKey('kode_merek_motor');
        $this->forge->addUniqueKey('nama_merek_motor');
        $this->forge->createTable('merek_motor');

        $this->forge->addField([
            'id_mekanik'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_mekanik' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_mekanik' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_mekanik', true);
        $this->forge->addUniqueKey('kode_mekanik');
        $this->forge->createTable('mekanik');

        $this->forge->addField([
            'id_pemasok'       => ['type' => 'INT', 'auto_increment' => true],
            'kode_pemasok'     => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_pemasok'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'nomor_hp_pemasok' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'alamat_pemasok'   => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id_pemasok', true);
        $this->forge->addUniqueKey('kode_pemasok');
        $this->forge->createTable('pemasok');

        $this->forge->addField([
            'id_pelanggan'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_pelanggan' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_pelanggan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'nomor_hp'       => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
        ]);
        $this->forge->addKey('id_pelanggan', true);
        $this->forge->addUniqueKey('kode_pelanggan');
        $this->forge->createTable('pelanggan');

        $this->forge->addField([
            'id_pengguna'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_pengguna' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_pengguna' => ['type' => 'VARCHAR', 'constraint' => 50],
            'kata_sandi'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'peran'         => ['type' => 'ENUM("Pemilik","Admin","Mekanik")'],
        ]);
        $this->forge->addKey('id_pengguna', true);
        $this->forge->addUniqueKey('kode_pengguna');
        $this->forge->addUniqueKey('nama_pengguna');
        $this->forge->createTable('pengguna');

        $this->forge->addField([
            'id_jasa'       => ['type' => 'INT', 'auto_increment' => true],
            'kode_jasa'     => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nama_jasa'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'biaya_standar' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
        ]);
        $this->forge->addKey('id_jasa', true);
        $this->forge->addUniqueKey('kode_jasa');
        $this->forge->createTable('jasa_servis');
    }

    public function down()
    {
        $this->forge->dropTable('jasa_servis');
        $this->forge->dropTable('pengguna');
        $this->forge->dropTable('pelanggan');
        $this->forge->dropTable('pemasok');
        $this->forge->dropTable('mekanik');
        $this->forge->dropTable('merek_motor');
        $this->forge->dropTable('merek_part');
        $this->forge->dropTable('kategori_part');
        $this->forge->dropTable('kategori_biaya_operasional');
        $this->forge->dropTable('counter_kode');
    }
}