<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMotorTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tipe_motor'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_tipe_motor' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'id_merek_motor'  => ['type' => 'INT'],
            'nama_tipe'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'jenis_kendaraan' => ['type' => 'ENUM("Matic","Bebek","Sport","Lainnya")', 'default' => 'Matic'],
        ]);
        $this->forge->addKey('id_tipe_motor', true);
        $this->forge->addUniqueKey('kode_tipe_motor');
        $this->forge->addForeignKey('id_merek_motor', 'merek_motor', 'id_merek_motor', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('tipe_motor');

        $this->forge->addField([
            'id_kendaraan'   => ['type' => 'INT', 'auto_increment' => true],
            'kode_kendaraan' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'id_pelanggan'   => ['type' => 'INT'],
            'id_tipe_motor'  => ['type' => 'INT'],
            'nomor_plat'     => ['type' => 'VARCHAR', 'constraint' => 15],
        ]);
        $this->forge->addKey('id_kendaraan', true);
        $this->forge->addUniqueKey('kode_kendaraan');
        $this->forge->addUniqueKey('nomor_plat');
        $this->forge->addForeignKey('id_pelanggan', 'pelanggan', 'id_pelanggan', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_tipe_motor', 'tipe_motor', 'id_tipe_motor', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('kendaraan');
    }

    public function down()
    {
        $this->forge->dropTable('kendaraan');
        $this->forge->dropTable('tipe_motor');
    }
}