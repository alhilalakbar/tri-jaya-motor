<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinanceTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_biaya_operasional' => ['type' => 'INT', 'auto_increment' => true],
            'id_pengguna'          => ['type' => 'INT'],
            'id_kategori_biaya'    => ['type' => 'INT'],
            'tanggal_biaya'        => ['type' => 'DATETIME', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'nominal'              => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'keterangan'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id_biaya_operasional', true);
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_kategori_biaya', 'kategori_biaya_operasional', 'id_kategori_biaya', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('biaya_operasional');

        $this->forge->addField([
            'id_gaji'       => ['type' => 'INT', 'auto_increment' => true],
            'id_mekanik'    => ['type' => 'INT'],
            'id_pengguna'   => ['type' => 'INT'],
            'tanggal_bayar' => ['type' => 'DATETIME', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'nominal'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'keterangan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id_gaji', true);
        $this->forge->addForeignKey('id_mekanik', 'mekanik', 'id_mekanik', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('gaji_harian_mekanik');
    }

    public function down()
    {
        $this->forge->dropTable('gaji_harian_mekanik');
        $this->forge->dropTable('biaya_operasional');
    }
}