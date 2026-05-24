<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialTriJayaMotorSchema extends Migration
{
    public function up()
    {
        $this->db->query('CREATE TABLE `biaya_operasional` (
  `id_biaya_operasional` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_kategori_biaya` int NOT NULL,
  `tanggal_biaya` datetime DEFAULT CURRENT_TIMESTAMP,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `counter_kode` (
  `nama_counter` varchar(50) NOT NULL,
  `counter_value` int NOT NULL DEFAULT \'0\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `detail_jasa_servis` (
  `id_detail_jasa` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_jasa` int NOT NULL,
  `harga_saat_transaksi` decimal(12,2) DEFAULT \'0.00\',
  `biaya_tambahan` decimal(12,2) DEFAULT \'0.00\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `detail_pembelian_stok` (
  `id_detail_pembelian` int NOT NULL,
  `id_pembelian` int DEFAULT NULL,
  `id_part` int DEFAULT NULL,
  `jumlah_beli` int NOT NULL,
  `harga_beli_satuan` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `detail_penggunaan_part` (
  `id_detail_part` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_part` int NOT NULL,
  `jumlah_pakai` int NOT NULL,
  `harga_satuan_jual` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(12,2) GENERATED ALWAYS AS ((`jumlah_pakai` * `harga_satuan_jual`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `gaji_harian_mekanik` (
  `id_gaji` int NOT NULL,
  `id_mekanik` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `tanggal_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `jasa_luar_bubut` (
  `id_jasa_luar` int NOT NULL,
  `kode_jasa_luar` varchar(15) DEFAULT NULL,
  `id_transaksi` int DEFAULT NULL,
  `deskripsi_pekerjaan` text,
  `biaya_modal_vendor` decimal(12,2) DEFAULT NULL,
  `tagihan_ke_pelanggan` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `jasa_servis` (
  `id_jasa` int NOT NULL,
  `kode_jasa` varchar(10) DEFAULT NULL,
  `nama_jasa` varchar(100) NOT NULL,
  `biaya_standar` decimal(12,2) DEFAULT \'0.00\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `kategori_biaya_operasional` (
  `id_kategori_biaya` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `kategori_part` (
  `id_kategori` int NOT NULL,
  `kode_kategori` varchar(10) DEFAULT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `kendaraan` (
  `id_kendaraan` int NOT NULL,
  `kode_kendaraan` varchar(10) DEFAULT NULL,
  `id_pelanggan` int NOT NULL,
  `id_tipe_motor` int NOT NULL,
  `nomor_plat` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `mekanik` (
  `id_mekanik` int NOT NULL,
  `kode_mekanik` varchar(10) DEFAULT NULL,
  `nama_mekanik` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `merek_motor` (
  `id_merek_motor` int NOT NULL,
  `kode_merek_motor` varchar(10) DEFAULT NULL,
  `nama_merek_motor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `merek_part` (
  `id_merek_part` int NOT NULL,
  `kode_merek_part` varchar(10) DEFAULT NULL,
  `nama_merek_part` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL,
  `kode_pelanggan` varchar(10) DEFAULT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `pemasok` (
  `id_pemasok` int NOT NULL,
  `kode_pemasok` varchar(10) DEFAULT NULL,
  `nama_pemasok` varchar(100) NOT NULL,
  `nomor_hp_pemasok` varchar(15) DEFAULT NULL,
  `alamat_pemasok` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `pembelian_stok` (
  `id_pembelian` int NOT NULL,
  `kode_pembelian` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_pemasok` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `tanggal_pembelian` datetime DEFAULT NULL,
  `total_biaya_pembelian` decimal(15,2) DEFAULT \'0.00\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `kode_pengguna` varchar(10) DEFAULT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum(\'Pemilik\',\'Admin\',\'Mekanik\') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `sparepart` (
  `id_part` int NOT NULL,
  `kode_part` varchar(10) DEFAULT NULL,
  `id_kategori` int NOT NULL,
  `id_merek_part` int DEFAULT NULL,
  `nama_part` varchar(100) NOT NULL,
  `kualitas_part` enum(\'Original\',\'OEM\',\'KW\') DEFAULT \'Original\',
  `harga_modal` decimal(12,2) DEFAULT \'0.00\',
  `harga_jual` decimal(12,2) DEFAULT \'0.00\',
  `stok_saat_ini` int DEFAULT \'0\',
  `stok_minimum` int DEFAULT \'5\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `tipe_motor` (
  `id_tipe_motor` int NOT NULL,
  `kode_tipe_motor` varchar(10) DEFAULT NULL,
  `id_merek_motor` int NOT NULL,
  `nama_tipe` varchar(100) NOT NULL,
  `jenis_kendaraan` enum(\'Matic\',\'Bebek\',\'Sport\',\'Lainnya\') DEFAULT \'Matic\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('CREATE TABLE `transaksi_servis` (
  `id_transaksi` int NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL,
  `id_kendaraan` int NOT NULL,
  `id_mekanik` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `tanggal_masuk` datetime DEFAULT CURRENT_TIMESTAMP,
  `keluhan_awal` text,
  `hasil_pemeriksaan` text,
  `status_pengerjaan` enum(\'Antre\',\'Diproses\',\'Menunggu Part\',\'Selesai\',\'Diambil\',\'Dibatalkan\') DEFAULT NULL,
  `metode_pembayaran` enum(\'Tunai\',\'QRIS\') DEFAULT \'Tunai\',
  `status_pembayaran` enum(\'Lunas\',\'Belum Lunas\') DEFAULT \'Belum Lunas\',
  `total_biaya` decimal(15,2) DEFAULT \'0.00\'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;');

        $this->db->query('ALTER TABLE `biaya_operasional`
  ADD PRIMARY KEY (`id_biaya_operasional`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kategori_biaya` (`id_kategori_biaya`);');

        $this->db->query('ALTER TABLE `counter_kode`
  ADD PRIMARY KEY (`nama_counter`);');

        $this->db->query('ALTER TABLE `detail_jasa_servis`
  ADD PRIMARY KEY (`id_detail_jasa`),
  ADD UNIQUE KEY `unique_jasa_per_transaksi` (`id_transaksi`,`id_jasa`),
  ADD KEY `fk_det_jasa_master` (`id_jasa`);');

        $this->db->query('ALTER TABLE `detail_pembelian_stok`
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `fk_det_beli_master` (`id_pembelian`),
  ADD KEY `fk_det_beli_part` (`id_part`);');

        $this->db->query('ALTER TABLE `detail_penggunaan_part`
  ADD PRIMARY KEY (`id_detail_part`),
  ADD UNIQUE KEY `unique_part_per_transaksi` (`id_transaksi`,`id_part`),
  ADD KEY `fk_det_pakai_part` (`id_part`),
  ADD KEY `idx_detail_transaksi` (`id_transaksi`);');

        $this->db->query('ALTER TABLE `gaji_harian_mekanik`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `fk_gaji_mekanik` (`id_mekanik`),
  ADD KEY `fk_gaji_mekanik_pengguna` (`id_pengguna`);');

        $this->db->query('ALTER TABLE `jasa_luar_bubut`
  ADD PRIMARY KEY (`id_jasa_luar`),
  ADD UNIQUE KEY `kode_jasa_luar` (`kode_jasa_luar`),
  ADD KEY `fk_bubut_trans` (`id_transaksi`);');

        $this->db->query('ALTER TABLE `jasa_servis`
  ADD PRIMARY KEY (`id_jasa`),
  ADD UNIQUE KEY `kode_jasa` (`kode_jasa`);');

        $this->db->query('ALTER TABLE `kategori_biaya_operasional`
  ADD PRIMARY KEY (`id_kategori_biaya`);');

        $this->db->query('ALTER TABLE `kategori_part`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);');

        $this->db->query('ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `nomor_plat` (`nomor_plat`),
  ADD UNIQUE KEY `kode_kendaraan` (`kode_kendaraan`),
  ADD KEY `fk_kendaraan_tipe` (`id_tipe_motor`),
  ADD KEY `idx_kendaraan_pelanggan` (`id_pelanggan`);');

        $this->db->query('ALTER TABLE `mekanik`
  ADD PRIMARY KEY (`id_mekanik`),
  ADD UNIQUE KEY `kode_mekanik` (`kode_mekanik`);');

        $this->db->query('ALTER TABLE `merek_motor`
  ADD PRIMARY KEY (`id_merek_motor`),
  ADD UNIQUE KEY `nama_merk` (`nama_merek_motor`),
  ADD UNIQUE KEY `kode_merk_motor` (`kode_merek_motor`);');

        $this->db->query('ALTER TABLE `merek_part`
  ADD PRIMARY KEY (`id_merek_part`),
  ADD UNIQUE KEY `nama_merek` (`nama_merek_part`),
  ADD UNIQUE KEY `kode_merek_part` (`kode_merek_part`);');

        $this->db->query('ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`);');

        $this->db->query('ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`id_pemasok`),
  ADD UNIQUE KEY `kode_pemasok` (`kode_pemasok`);');

        $this->db->query('ALTER TABLE `pembelian_stok`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD UNIQUE KEY `kode_pembelian` (`kode_pembelian`),
  ADD KEY `fk_beli_pemasok` (`id_pemasok`),
  ADD KEY `fk_beli_pengguna` (`id_pengguna`);');

        $this->db->query('ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nama_pengguna` (`nama_pengguna`),
  ADD UNIQUE KEY `kode_pengguna` (`kode_pengguna`);');

        $this->db->query('ALTER TABLE `sparepart`
  ADD PRIMARY KEY (`id_part`),
  ADD UNIQUE KEY `uq_nama_part` (`nama_part`),
  ADD UNIQUE KEY `kode_part` (`kode_part`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_merek_part` (`id_merek_part`);');

        $this->db->query('ALTER TABLE `tipe_motor`
  ADD PRIMARY KEY (`id_tipe_motor`),
  ADD UNIQUE KEY `kode_tipe_motor` (`kode_tipe_motor`),
  ADD KEY `fk_tipe_merek` (`id_merek_motor`);');

        $this->db->query('ALTER TABLE `transaksi_servis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `fk_trans_mekanik` (`id_mekanik`),
  ADD KEY `fk_trans_pengguna` (`id_pengguna`),
  ADD KEY `fk_trans_kendaraan` (`id_kendaraan`),
  ADD KEY `idx_transaksi_tanggal` (`tanggal_masuk`);');

        $this->db->query('ALTER TABLE `biaya_operasional`
  MODIFY `id_biaya_operasional` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `detail_jasa_servis`
  MODIFY `id_detail_jasa` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `detail_pembelian_stok`
  MODIFY `id_detail_pembelian` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `detail_penggunaan_part`
  MODIFY `id_detail_part` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `gaji_harian_mekanik`
  MODIFY `id_gaji` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `jasa_luar_bubut`
  MODIFY `id_jasa_luar` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `jasa_servis`
  MODIFY `id_jasa` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `kategori_biaya_operasional`
  MODIFY `id_kategori_biaya` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `kategori_part`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `mekanik`
  MODIFY `id_mekanik` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `merek_motor`
  MODIFY `id_merek_motor` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `merek_part`
  MODIFY `id_merek_part` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `pemasok`
  MODIFY `id_pemasok` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `pembelian_stok`
  MODIFY `id_pembelian` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `sparepart`
  MODIFY `id_part` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `tipe_motor`
  MODIFY `id_tipe_motor` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `transaksi_servis`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `biaya_operasional`
  ADD CONSTRAINT `fk_biaya_kategori` FOREIGN KEY (`id_kategori_biaya`) REFERENCES `kategori_biaya_operasional` (`id_kategori_biaya`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_biaya_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `detail_jasa_servis`
  ADD CONSTRAINT `fk_det_jasa_master` FOREIGN KEY (`id_jasa`) REFERENCES `jasa_servis` (`id_jasa`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_jasa_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `detail_pembelian_stok`
  ADD CONSTRAINT `fk_det_beli_master` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian_stok` (`id_pembelian`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_beli_part` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `detail_penggunaan_part`
  ADD CONSTRAINT `fk_det_pakai_part` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_pakai_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `gaji_harian_mekanik`
  ADD CONSTRAINT `fk_gaji_mekanik` FOREIGN KEY (`id_mekanik`) REFERENCES `mekanik` (`id_mekanik`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gaji_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `jasa_luar_bubut`
  ADD CONSTRAINT `fk_bubut_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `kendaraan`
  ADD CONSTRAINT `fk_kendaraan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kendaraan_tipe` FOREIGN KEY (`id_tipe_motor`) REFERENCES `tipe_motor` (`id_tipe_motor`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `pembelian_stok`
  ADD CONSTRAINT `fk_beli_pemasok` FOREIGN KEY (`id_pemasok`) REFERENCES `pemasok` (`id_pemasok`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_beli_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `sparepart`
  ADD CONSTRAINT `fk_part_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_part` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_part_merek` FOREIGN KEY (`id_merek_part`) REFERENCES `merek_part` (`id_merek_part`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `tipe_motor`
  ADD CONSTRAINT `fk_tipe_merek_motor` FOREIGN KEY (`id_merek_motor`) REFERENCES `merek_motor` (`id_merek_motor`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `transaksi_servis`
  ADD CONSTRAINT `fk_trans_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_mekanik` FOREIGN KEY (`id_mekanik`) REFERENCES `mekanik` (`id_mekanik`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;');

        $this->db->query('CREATE TRIGGER `update_total_after_delete_jasa` AFTER DELETE ON `detail_jasa_servis` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = OLD.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = OLD.id_transaksi), 0
    )
  )
  WHERE id_transaksi = OLD.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `update_total_after_jasa` AFTER INSERT ON `detail_jasa_servis` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
  )
  WHERE id_transaksi = NEW.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `update_total_after_update_jasa` AFTER UPDATE ON `detail_jasa_servis` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
  )
  WHERE id_transaksi = NEW.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `tambah_stok_dan_update_harga` AFTER INSERT ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    -- 1. Update jumlah stok
    -- 2. Update harga_modal dengan harga beli terbaru
    UPDATE sparepart 
    SET 
        stok_saat_ini = stok_saat_ini + NEW.jumlah_beli,
        harga_modal = NEW.harga_beli_satuan
    WHERE id_part = NEW.id_part;
END
');

        $this->db->query('CREATE TRIGGER `update_total_pembelian_delete` AFTER DELETE ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = OLD.id_pembelian
    )
    WHERE id_pembelian = OLD.id_pembelian;
END
');

        $this->db->query('CREATE TRIGGER `update_total_pembelian_insert` AFTER INSERT ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = NEW.id_pembelian
    )
    WHERE id_pembelian = NEW.id_pembelian;
END
');

        $this->db->query('CREATE TRIGGER `update_total_pembelian_update` AFTER UPDATE ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = NEW.id_pembelian
    )
    WHERE id_pembelian = NEW.id_pembelian;
END
');

        $this->db->query('CREATE TRIGGER `cek_dan_kurangi_stok` BEFORE INSERT ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    DECLARE stok_sekarang INT;

    SELECT stok_saat_ini INTO stok_sekarang
    FROM sparepart
    WHERE id_part = NEW.id_part
    FOR UPDATE;

    IF stok_sekarang < NEW.jumlah_pakai THEN
        SIGNAL SQLSTATE \'45000\'
        SET MESSAGE_TEXT = \'Stok tidak mencukupi\';
    ELSE
        UPDATE sparepart
        SET stok_saat_ini = stok_saat_ini - NEW.jumlah_pakai
        WHERE id_part = NEW.id_part;
    END IF;
END
');

        $this->db->query('CREATE TRIGGER `kembalikan_stok_batal` AFTER DELETE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    UPDATE sparepart 
    SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai 
    WHERE id_part = OLD.id_part;
END
');

        $this->db->query('CREATE TRIGGER `update_stok_part` AFTER UPDATE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    UPDATE sparepart
    SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai - NEW.jumlah_pakai
    WHERE id_part = NEW.id_part;
END
');

        $this->db->query('CREATE TRIGGER `update_total_after_delete_part` AFTER DELETE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = OLD.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = OLD.id_transaksi), 0
    )
  )
  WHERE id_transaksi = OLD.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `update_total_after_part` AFTER INSERT ON `detail_penggunaan_part` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
  )
  WHERE id_transaksi = NEW.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `update_total_after_update_part` AFTER UPDATE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
  UPDATE transaksi_servis
  SET total_biaya = (
    COALESCE(
      (SELECT SUM(subtotal)
       FROM detail_penggunaan_part
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
    +
    COALESCE(
      (SELECT SUM(harga_saat_transaksi + biaya_tambahan)
       FROM detail_jasa_servis
       WHERE id_transaksi = NEW.id_transaksi), 0
    )
  )
  WHERE id_transaksi = NEW.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_jasa_luar` BEFORE INSERT ON `jasa_luar_bubut` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'jasa_luar\';

    SET NEW.kode_jasa_luar = CONCAT(\'JSL-\', LPAD(LAST_INSERT_ID(), 4, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_jasa` BEFORE INSERT ON `jasa_servis` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'jasa\';

    SET NEW.kode_jasa = CONCAT(\'JSA-\', LPAD(LAST_INSERT_ID(), 3, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_kategori_part` BEFORE INSERT ON `kategori_part` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'kategori_part\';

    SET NEW.kode_kategori = CONCAT(\'KAT-\', LPAD(LAST_INSERT_ID(), 3, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_kendaraan` BEFORE INSERT ON `kendaraan` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'kendaraan\';

    SET NEW.kode_kendaraan = CONCAT(\'KND-\', LPAD(LAST_INSERT_ID(), 4, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_mekanik` BEFORE INSERT ON `mekanik` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'mekanik\';

    SET NEW.kode_mekanik = CONCAT(\'MKN-\', LPAD(LAST_INSERT_ID(), 3, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_merek_motor` BEFORE INSERT ON `merek_motor` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'merek_motor\';

    SET NEW.kode_merek_motor = CONCAT(
        \'MKT-\',
        LPAD(LAST_INSERT_ID(), 4, \'0\')
    );
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_merek_part` BEFORE INSERT ON `merek_part` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'merek_part\';

    SET NEW.kode_merek_part = CONCAT(\'MRK-\', LPAD(LAST_INSERT_ID(), 3, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_pelanggan` BEFORE INSERT ON `pelanggan` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'pelanggan\';

    SET NEW.kode_pelanggan = CONCAT(\'PLG-\', LPAD(LAST_INSERT_ID(), 4, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_pemasok` BEFORE INSERT ON `pemasok` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'pemasok\';

    SET NEW.kode_pemasok = CONCAT(\'SUP-\', LPAD(LAST_INSERT_ID(), 4, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_pembelian` BEFORE INSERT ON `pembelian_stok` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'pembelian\';
    SET NEW.kode_pembelian = CONCAT(
        \'PUR-\',
        DATE_FORMAT(NOW(), \'%Y%m%d\'),
        \'-\',
        LPAD(LAST_INSERT_ID(), 4, \'0\')
    );
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_pengguna` BEFORE INSERT ON `pengguna` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'pengguna\';

    SET NEW.kode_pengguna = CONCAT(\'USR-\', LPAD(LAST_INSERT_ID(), 4, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_part` BEFORE INSERT ON `sparepart` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'sparepart\';

    SET NEW.kode_part = CONCAT(\'PRT-\', LPAD(LAST_INSERT_ID(), 5, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_tipe_motor` BEFORE INSERT ON `tipe_motor` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'tipe_motor\';

    SET NEW.kode_tipe_motor = CONCAT(\'TPM-\', LPAD(LAST_INSERT_ID(), 3, \'0\'));
END
');

        $this->db->query('CREATE TRIGGER `batal_kembalikan_stok` AFTER UPDATE ON `transaksi_servis` FOR EACH ROW BEGIN
  IF NEW.status_pengerjaan = \'Dibatalkan\'
     AND OLD.status_pengerjaan <> \'Dibatalkan\' THEN

    UPDATE sparepart sc
    JOIN detail_penggunaan_part dpp 
      ON sc.id_part = dpp.id_part
    SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai
    WHERE dpp.id_transaksi = NEW.id_transaksi;

  END IF;
END
');

        $this->db->query('CREATE TRIGGER `rollback_stok_transaksi` AFTER DELETE ON `transaksi_servis` FOR EACH ROW BEGIN
    UPDATE sparepart sc
    JOIN detail_penggunaan_part dpp 
      ON sc.id_part = dpp.id_part
    SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai
    WHERE dpp.id_transaksi = OLD.id_transaksi;
END
');

        $this->db->query('CREATE TRIGGER `tg_kode_transaksi` BEFORE INSERT ON `transaksi_servis` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = \'transaksi\';

    SET NEW.kode_transaksi = CONCAT(
        \'TRX-\',
        DATE_FORMAT(NOW(), \'%Y%m%d\'),
        \'-\',
        LPAD(LAST_INSERT_ID(), 4, \'0\')
    );
END
');

    }

    public function down()
    {
        $this->forge->dropTable('transaksi_servis', true);
        $this->forge->dropTable('tipe_motor', true);
        $this->forge->dropTable('sparepart', true);
        $this->forge->dropTable('pengguna', true);
        $this->forge->dropTable('pembelian_stok', true);
        $this->forge->dropTable('pemasok', true);
        $this->forge->dropTable('pelanggan', true);
        $this->forge->dropTable('merek_part', true);
        $this->forge->dropTable('merek_motor', true);
        $this->forge->dropTable('mekanik', true);
        $this->forge->dropTable('kendaraan', true);
        $this->forge->dropTable('kategori_part', true);
        $this->forge->dropTable('kategori_biaya_operasional', true);
        $this->forge->dropTable('jasa_servis', true);
        $this->forge->dropTable('jasa_luar_bubut', true);
        $this->forge->dropTable('gaji_harian_mekanik', true);
        $this->forge->dropTable('detail_penggunaan_part', true);
        $this->forge->dropTable('detail_pembelian_stok', true);
        $this->forge->dropTable('detail_jasa_servis', true);
        $this->forge->dropTable('counter_kode', true);
        $this->forge->dropTable('biaya_operasional', true);
    }
}
