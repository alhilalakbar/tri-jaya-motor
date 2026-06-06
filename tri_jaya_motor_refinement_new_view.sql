-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 06, 2026 at 03:34 PM
-- Server version: 8.0.46-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tri_jaya_motor_refinement`
--

-- --------------------------------------------------------

--
-- Table structure for table `biaya_operasional`
--

CREATE TABLE `biaya_operasional` (
  `id_biaya_operasional` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_kategori_biaya` int NOT NULL,
  `tanggal_biaya` datetime DEFAULT CURRENT_TIMESTAMP,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counter_kode`
--

CREATE TABLE `counter_kode` (
  `nama_counter` varchar(50) NOT NULL,
  `counter_value` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_jasa_servis`
--

CREATE TABLE `detail_jasa_servis` (
  `id_detail_jasa` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_jasa` int NOT NULL,
  `harga_saat_transaksi` decimal(12,2) DEFAULT '0.00',
  `biaya_tambahan` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `detail_jasa_servis`
--
DELIMITER $$
CREATE TRIGGER `update_total_after_delete_jasa` AFTER DELETE ON `detail_jasa_servis` FOR EACH ROW BEGIN
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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_after_jasa` AFTER INSERT ON `detail_jasa_servis` FOR EACH ROW BEGIN
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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_after_update_jasa` AFTER UPDATE ON `detail_jasa_servis` FOR EACH ROW BEGIN
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian_stok`
--

CREATE TABLE `detail_pembelian_stok` (
  `id_detail_pembelian` int NOT NULL,
  `id_pembelian` int DEFAULT NULL,
  `id_part` int DEFAULT NULL,
  `jumlah_beli` int NOT NULL,
  `harga_beli_satuan` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `detail_pembelian_stok`
--
DELIMITER $$
CREATE TRIGGER `tambah_stok_dan_update_harga` AFTER INSERT ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    -- 1. Update jumlah stok
    -- 2. Update harga_modal dengan harga beli terbaru
    UPDATE sparepart 
    SET 
        stok_saat_ini = stok_saat_ini + NEW.jumlah_beli,
        harga_modal = NEW.harga_beli_satuan
    WHERE id_part = NEW.id_part;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_pembelian_delete` AFTER DELETE ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = OLD.id_pembelian
    )
    WHERE id_pembelian = OLD.id_pembelian;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_pembelian_insert` AFTER INSERT ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = NEW.id_pembelian
    )
    WHERE id_pembelian = NEW.id_pembelian;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_pembelian_update` AFTER UPDATE ON `detail_pembelian_stok` FOR EACH ROW BEGIN
    UPDATE pembelian_stok 
    SET total_biaya_pembelian = (
        SELECT SUM(jumlah_beli * harga_beli_satuan) 
        FROM detail_pembelian_stok 
        WHERE id_pembelian = NEW.id_pembelian
    )
    WHERE id_pembelian = NEW.id_pembelian;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penggunaan_part`
--

CREATE TABLE `detail_penggunaan_part` (
  `id_detail_part` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_part` int NOT NULL,
  `jumlah_pakai` int NOT NULL,
  `harga_satuan_jual` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(12,2) GENERATED ALWAYS AS ((`jumlah_pakai` * `harga_satuan_jual`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `detail_penggunaan_part`
--
DELIMITER $$
CREATE TRIGGER `cek_dan_kurangi_stok` BEFORE INSERT ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    DECLARE stok_sekarang INT;

    SELECT stok_saat_ini INTO stok_sekarang
    FROM sparepart
    WHERE id_part = NEW.id_part
    FOR UPDATE;

    IF stok_sekarang < NEW.jumlah_pakai THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stok tidak mencukupi';
    ELSE
        UPDATE sparepart
        SET stok_saat_ini = stok_saat_ini - NEW.jumlah_pakai
        WHERE id_part = NEW.id_part;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kembalikan_stok_batal` AFTER DELETE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    UPDATE sparepart 
    SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai 
    WHERE id_part = OLD.id_part;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_part` AFTER UPDATE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
    UPDATE sparepart
    SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai - NEW.jumlah_pakai
    WHERE id_part = NEW.id_part;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_after_delete_part` AFTER DELETE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_after_part` AFTER INSERT ON `detail_penggunaan_part` FOR EACH ROW BEGIN
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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_after_update_part` AFTER UPDATE ON `detail_penggunaan_part` FOR EACH ROW BEGIN
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_harian_mekanik`
--

CREATE TABLE `gaji_harian_mekanik` (
  `id_gaji` int NOT NULL,
  `id_mekanik` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `tanggal_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jasa_luar_bubut`
--

CREATE TABLE `jasa_luar_bubut` (
  `id_jasa_luar` int NOT NULL,
  `kode_jasa_luar` varchar(15) DEFAULT NULL,
  `id_transaksi` int DEFAULT NULL,
  `deskripsi_pekerjaan` text,
  `biaya_modal_vendor` decimal(12,2) DEFAULT NULL,
  `tagihan_ke_pelanggan` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `jasa_luar_bubut`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_jasa_luar` BEFORE INSERT ON `jasa_luar_bubut` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'jasa_luar';

    SET NEW.kode_jasa_luar = CONCAT('JSL-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jasa_servis`
--

CREATE TABLE `jasa_servis` (
  `id_jasa` int NOT NULL,
  `kode_jasa` varchar(10) DEFAULT NULL,
  `nama_jasa` varchar(100) NOT NULL,
  `biaya_standar` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `jasa_servis`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_jasa` BEFORE INSERT ON `jasa_servis` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'jasa';

    SET NEW.kode_jasa = CONCAT('JSA-', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_biaya_operasional`
--

CREATE TABLE `kategori_biaya_operasional` (
  `id_kategori_biaya` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_part`
--

CREATE TABLE `kategori_part` (
  `id_kategori` int NOT NULL,
  `kode_kategori` varchar(10) DEFAULT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `kategori_part`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_kategori_part` BEFORE INSERT ON `kategori_part` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'kategori_part';

    SET NEW.kode_kategori = CONCAT('KAT-', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int NOT NULL,
  `kode_kendaraan` varchar(10) DEFAULT NULL,
  `id_pelanggan` int NOT NULL,
  `id_tipe_motor` int NOT NULL,
  `nomor_plat` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `kendaraan`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_kendaraan` BEFORE INSERT ON `kendaraan` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'kendaraan';

    SET NEW.kode_kendaraan = CONCAT('KND-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mekanik`
--

CREATE TABLE `mekanik` (
  `id_mekanik` int NOT NULL,
  `kode_mekanik` varchar(10) DEFAULT NULL,
  `nama_mekanik` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `mekanik`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_mekanik` BEFORE INSERT ON `mekanik` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'mekanik';

    SET NEW.kode_mekanik = CONCAT('MKN-', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `merek_motor`
--

CREATE TABLE `merek_motor` (
  `id_merek_motor` int NOT NULL,
  `kode_merek_motor` varchar(10) DEFAULT NULL,
  `nama_merek_motor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `merek_motor`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_merek_motor` BEFORE INSERT ON `merek_motor` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'merek_motor';

    SET NEW.kode_merek_motor = CONCAT(
        'MKT-',
        LPAD(LAST_INSERT_ID(), 4, '0')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `merek_part`
--

CREATE TABLE `merek_part` (
  `id_merek_part` int NOT NULL,
  `kode_merek_part` varchar(10) DEFAULT NULL,
  `nama_merek_part` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `merek_part`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_merek_part` BEFORE INSERT ON `merek_part` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'merek_part';

    SET NEW.kode_merek_part = CONCAT('MRK-', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL,
  `kode_pelanggan` varchar(10) DEFAULT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_pelanggan` BEFORE INSERT ON `pelanggan` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'pelanggan';

    SET NEW.kode_pelanggan = CONCAT('PLG-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pemasok`
--

CREATE TABLE `pemasok` (
  `id_pemasok` int NOT NULL,
  `kode_pemasok` varchar(10) DEFAULT NULL,
  `nama_pemasok` varchar(100) NOT NULL,
  `nomor_hp_pemasok` varchar(15) DEFAULT NULL,
  `alamat_pemasok` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `pemasok`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_pemasok` BEFORE INSERT ON `pemasok` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'pemasok';

    SET NEW.kode_pemasok = CONCAT('SUP-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_stok`
--

CREATE TABLE `pembelian_stok` (
  `id_pembelian` int NOT NULL,
  `kode_pembelian` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_pemasok` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `tanggal_pembelian` datetime DEFAULT NULL,
  `total_biaya_pembelian` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `pembelian_stok`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_pembelian` BEFORE INSERT ON `pembelian_stok` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'pembelian';
    SET NEW.kode_pembelian = CONCAT(
        'PUR-',
        DATE_FORMAT(NOW(), '%Y%m%d'),
        '-',
        LPAD(LAST_INSERT_ID(), 4, '0')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `kode_pengguna` varchar(10) DEFAULT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('Pemilik','Admin','Mekanik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `pengguna`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_pengguna` BEFORE INSERT ON `pengguna` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'pengguna';

    SET NEW.kode_pengguna = CONCAT('USR-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sparepart`
--

CREATE TABLE `sparepart` (
  `id_part` int NOT NULL,
  `kode_part` varchar(10) DEFAULT NULL,
  `id_kategori` int NOT NULL,
  `id_merek_part` int DEFAULT NULL,
  `nama_part` varchar(100) NOT NULL,
  `kualitas_part` enum('Original','OEM','KW') DEFAULT 'Original',
  `harga_modal` decimal(12,2) DEFAULT '0.00',
  `harga_jual` decimal(12,2) DEFAULT '0.00',
  `stok_saat_ini` int DEFAULT '0',
  `stok_minimum` int DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `sparepart`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_part` BEFORE INSERT ON `sparepart` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'sparepart';

    SET NEW.kode_part = CONCAT('PRT-', LPAD(LAST_INSERT_ID(), 5, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tipe_motor`
--

CREATE TABLE `tipe_motor` (
  `id_tipe_motor` int NOT NULL,
  `kode_tipe_motor` varchar(10) DEFAULT NULL,
  `id_merek_motor` int NOT NULL,
  `nama_tipe` varchar(100) NOT NULL,
  `jenis_kendaraan` enum('Matic','Bebek','Sport','Lainnya') DEFAULT 'Matic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `tipe_motor`
--
DELIMITER $$
CREATE TRIGGER `tg_kode_tipe_motor` BEFORE INSERT ON `tipe_motor` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'tipe_motor';

    SET NEW.kode_tipe_motor = CONCAT('TPM-', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_servis`
--

CREATE TABLE `transaksi_servis` (
  `id_transaksi` int NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL,
  `id_kendaraan` int NOT NULL,
  `id_mekanik` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `tanggal_masuk` datetime DEFAULT CURRENT_TIMESTAMP,
  `keluhan_awal` text,
  `hasil_pemeriksaan` text,
  `status_pengerjaan` enum('Antre','Diproses','Menunggu Part','Selesai','Diambil','Dibatalkan') DEFAULT NULL,
  `metode_pembayaran` enum('Tunai','QRIS','BRI','Dana') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Tunai',
  `status_pembayaran` enum('Lunas','Belum Lunas') DEFAULT 'Belum Lunas',
  `total_biaya` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `transaksi_servis`
--
DELIMITER $$
CREATE TRIGGER `batal_kembalikan_stok` AFTER UPDATE ON `transaksi_servis` FOR EACH ROW BEGIN
  IF NEW.status_pengerjaan = 'Dibatalkan'
     AND OLD.status_pengerjaan <> 'Dibatalkan' THEN

    UPDATE sparepart sc
    JOIN detail_penggunaan_part dpp 
      ON sc.id_part = dpp.id_part
    SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai
    WHERE dpp.id_transaksi = NEW.id_transaksi;

  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rollback_stok_transaksi` AFTER DELETE ON `transaksi_servis` FOR EACH ROW BEGIN
    UPDATE sparepart sc
    JOIN detail_penggunaan_part dpp 
      ON sc.id_part = dpp.id_part
    SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai
    WHERE dpp.id_transaksi = OLD.id_transaksi;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_kode_transaksi` BEFORE INSERT ON `transaksi_servis` FOR EACH ROW BEGIN
    UPDATE counter_kode
    SET counter_value = LAST_INSERT_ID(counter_value + 1)
    WHERE nama_counter = 'transaksi';

    SET NEW.kode_transaksi = CONCAT(
        'TRX-',
        DATE_FORMAT(NOW(), '%Y%m%d'),
        '-',
        LPAD(LAST_INSERT_ID(), 4, '0')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_laba_rugi`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_laba_rugi` (
`kode_transaksi` varchar(20)
,`tanggal_masuk` datetime
,`status_pembayaran` enum('Lunas','Belum Lunas')
,`total_biaya` decimal(15,2)
,`jumlah_pakai` bigint
,`harga_modal` decimal(12,2)
,`hpp_sparepart` decimal(22,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_loyalitas_pelanggan`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_loyalitas_pelanggan` (
`kode_transaksi` varchar(20)
,`tanggal_masuk` datetime
,`kode_pelanggan` varchar(10)
,`nama_pelanggan` varchar(100)
,`total_biaya` decimal(15,2)
,`status_pembayaran` enum('Lunas','Belum Lunas')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_pembelian_stok`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_pembelian_stok` (
`kode_pembelian` varchar(20)
,`tanggal_pembelian` datetime
,`nama_pemasok` varchar(100)
,`nama_part` varchar(100)
,`jumlah_beli` int
,`harga_beli_satuan` decimal(12,2)
,`subtotal` decimal(22,2)
,`total_biaya_pembelian` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_pengeluaran`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_pengeluaran` (
`jenis_pengeluaran` varchar(17)
,`tanggal` datetime
,`nominal` decimal(12,2)
,`keterangan` varchar(255)
,`nama_kategori` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_performa_mekanik`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_performa_mekanik` (
`kode_transaksi` varchar(20)
,`tanggal_masuk` datetime
,`kode_mekanik` varchar(10)
,`nama_mekanik` varchar(100)
,`harga_saat_transaksi` decimal(12,2)
,`biaya_tambahan` decimal(12,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_stok_sparepart`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_stok_sparepart` (
`kode_part` varchar(10)
,`nama_part` varchar(100)
,`nama_kategori` varchar(50)
,`nama_merek_part` varchar(50)
,`kualitas_part` enum('Original','OEM','KW')
,`harga_jual` decimal(12,2)
,`stok_saat_ini` int
,`stok_minimum` int
,`status_stok` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_transaksi_servis`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_transaksi_servis` (
`kode_transaksi` varchar(20)
,`tanggal_masuk` datetime
,`nama_pelanggan` varchar(100)
,`nomor_plat` varchar(15)
,`nama_merek_motor` varchar(50)
,`nama_tipe` varchar(100)
,`nama_mekanik` varchar(100)
,`status_pengerjaan` enum('Antre','Diproses','Menunggu Part','Selesai','Diambil','Dibatalkan')
,`status_pembayaran` enum('Lunas','Belum Lunas')
,`metode_pembayaran` enum('Tunai','QRIS','BRI','Dana')
,`total_biaya` decimal(15,2)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  ADD PRIMARY KEY (`id_biaya_operasional`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kategori_biaya` (`id_kategori_biaya`);

--
-- Indexes for table `counter_kode`
--
ALTER TABLE `counter_kode`
  ADD PRIMARY KEY (`nama_counter`);

--
-- Indexes for table `detail_jasa_servis`
--
ALTER TABLE `detail_jasa_servis`
  ADD PRIMARY KEY (`id_detail_jasa`),
  ADD UNIQUE KEY `unique_jasa_per_transaksi` (`id_transaksi`,`id_jasa`),
  ADD KEY `fk_det_jasa_master` (`id_jasa`);

--
-- Indexes for table `detail_pembelian_stok`
--
ALTER TABLE `detail_pembelian_stok`
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `fk_det_beli_master` (`id_pembelian`),
  ADD KEY `fk_det_beli_part` (`id_part`);

--
-- Indexes for table `detail_penggunaan_part`
--
ALTER TABLE `detail_penggunaan_part`
  ADD PRIMARY KEY (`id_detail_part`),
  ADD UNIQUE KEY `unique_part_per_transaksi` (`id_transaksi`,`id_part`),
  ADD KEY `fk_det_pakai_part` (`id_part`),
  ADD KEY `idx_detail_transaksi` (`id_transaksi`);

--
-- Indexes for table `gaji_harian_mekanik`
--
ALTER TABLE `gaji_harian_mekanik`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `fk_gaji_mekanik` (`id_mekanik`),
  ADD KEY `fk_gaji_mekanik_pengguna` (`id_pengguna`);

--
-- Indexes for table `jasa_luar_bubut`
--
ALTER TABLE `jasa_luar_bubut`
  ADD PRIMARY KEY (`id_jasa_luar`),
  ADD UNIQUE KEY `kode_jasa_luar` (`kode_jasa_luar`),
  ADD KEY `fk_bubut_trans` (`id_transaksi`);

--
-- Indexes for table `jasa_servis`
--
ALTER TABLE `jasa_servis`
  ADD PRIMARY KEY (`id_jasa`),
  ADD UNIQUE KEY `kode_jasa` (`kode_jasa`);

--
-- Indexes for table `kategori_biaya_operasional`
--
ALTER TABLE `kategori_biaya_operasional`
  ADD PRIMARY KEY (`id_kategori_biaya`);

--
-- Indexes for table `kategori_part`
--
ALTER TABLE `kategori_part`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `nomor_plat` (`nomor_plat`),
  ADD UNIQUE KEY `kode_kendaraan` (`kode_kendaraan`),
  ADD KEY `fk_kendaraan_tipe` (`id_tipe_motor`),
  ADD KEY `idx_kendaraan_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `mekanik`
--
ALTER TABLE `mekanik`
  ADD PRIMARY KEY (`id_mekanik`),
  ADD UNIQUE KEY `kode_mekanik` (`kode_mekanik`);

--
-- Indexes for table `merek_motor`
--
ALTER TABLE `merek_motor`
  ADD PRIMARY KEY (`id_merek_motor`),
  ADD UNIQUE KEY `nama_merk` (`nama_merek_motor`),
  ADD UNIQUE KEY `kode_merk_motor` (`kode_merek_motor`);

--
-- Indexes for table `merek_part`
--
ALTER TABLE `merek_part`
  ADD PRIMARY KEY (`id_merek_part`),
  ADD UNIQUE KEY `nama_merek` (`nama_merek_part`),
  ADD UNIQUE KEY `kode_merek_part` (`kode_merek_part`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`);

--
-- Indexes for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`id_pemasok`),
  ADD UNIQUE KEY `kode_pemasok` (`kode_pemasok`);

--
-- Indexes for table `pembelian_stok`
--
ALTER TABLE `pembelian_stok`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD UNIQUE KEY `kode_pembelian` (`kode_pembelian`),
  ADD KEY `fk_beli_pemasok` (`id_pemasok`),
  ADD KEY `fk_beli_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nama_pengguna` (`nama_pengguna`),
  ADD UNIQUE KEY `kode_pengguna` (`kode_pengguna`);

--
-- Indexes for table `sparepart`
--
ALTER TABLE `sparepart`
  ADD PRIMARY KEY (`id_part`),
  ADD UNIQUE KEY `uq_nama_part` (`nama_part`),
  ADD UNIQUE KEY `kode_part` (`kode_part`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_merek_part` (`id_merek_part`);

--
-- Indexes for table `tipe_motor`
--
ALTER TABLE `tipe_motor`
  ADD PRIMARY KEY (`id_tipe_motor`),
  ADD UNIQUE KEY `kode_tipe_motor` (`kode_tipe_motor`),
  ADD KEY `fk_tipe_merek` (`id_merek_motor`);

--
-- Indexes for table `transaksi_servis`
--
ALTER TABLE `transaksi_servis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `fk_trans_mekanik` (`id_mekanik`),
  ADD KEY `fk_trans_pengguna` (`id_pengguna`),
  ADD KEY `fk_trans_kendaraan` (`id_kendaraan`),
  ADD KEY `idx_transaksi_tanggal` (`tanggal_masuk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  MODIFY `id_biaya_operasional` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_jasa_servis`
--
ALTER TABLE `detail_jasa_servis`
  MODIFY `id_detail_jasa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pembelian_stok`
--
ALTER TABLE `detail_pembelian_stok`
  MODIFY `id_detail_pembelian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_penggunaan_part`
--
ALTER TABLE `detail_penggunaan_part`
  MODIFY `id_detail_part` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaji_harian_mekanik`
--
ALTER TABLE `gaji_harian_mekanik`
  MODIFY `id_gaji` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jasa_luar_bubut`
--
ALTER TABLE `jasa_luar_bubut`
  MODIFY `id_jasa_luar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jasa_servis`
--
ALTER TABLE `jasa_servis`
  MODIFY `id_jasa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_biaya_operasional`
--
ALTER TABLE `kategori_biaya_operasional`
  MODIFY `id_kategori_biaya` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_part`
--
ALTER TABLE `kategori_part`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mekanik`
--
ALTER TABLE `mekanik`
  MODIFY `id_mekanik` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merek_motor`
--
ALTER TABLE `merek_motor`
  MODIFY `id_merek_motor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merek_part`
--
ALTER TABLE `merek_part`
  MODIFY `id_merek_part` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemasok`
--
ALTER TABLE `pemasok`
  MODIFY `id_pemasok` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_stok`
--
ALTER TABLE `pembelian_stok`
  MODIFY `id_pembelian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sparepart`
--
ALTER TABLE `sparepart`
  MODIFY `id_part` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipe_motor`
--
ALTER TABLE `tipe_motor`
  MODIFY `id_tipe_motor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_servis`
--
ALTER TABLE `transaksi_servis`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_laba_rugi`
--
DROP TABLE IF EXISTS `view_laporan_laba_rugi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_laba_rugi`  AS SELECT `ts`.`kode_transaksi` AS `kode_transaksi`, `ts`.`tanggal_masuk` AS `tanggal_masuk`, `ts`.`status_pembayaran` AS `status_pembayaran`, `ts`.`total_biaya` AS `total_biaya`, coalesce(`dpp`.`jumlah_pakai`,0) AS `jumlah_pakai`, coalesce(`s`.`harga_modal`,0) AS `harga_modal`, coalesce((`dpp`.`jumlah_pakai` * `s`.`harga_modal`),0) AS `hpp_sparepart` FROM ((`transaksi_servis` `ts` left join `detail_penggunaan_part` `dpp` on((`ts`.`id_transaksi` = `dpp`.`id_transaksi`))) left join `sparepart` `s` on((`dpp`.`id_part` = `s`.`id_part`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_loyalitas_pelanggan`
--
DROP TABLE IF EXISTS `view_laporan_loyalitas_pelanggan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_loyalitas_pelanggan`  AS SELECT `ts`.`kode_transaksi` AS `kode_transaksi`, `ts`.`tanggal_masuk` AS `tanggal_masuk`, `p`.`kode_pelanggan` AS `kode_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `ts`.`total_biaya` AS `total_biaya`, `ts`.`status_pembayaran` AS `status_pembayaran` FROM ((`transaksi_servis` `ts` join `kendaraan` `k` on((`ts`.`id_kendaraan` = `k`.`id_kendaraan`))) join `pelanggan` `p` on((`k`.`id_pelanggan` = `p`.`id_pelanggan`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_pembelian_stok`
--
DROP TABLE IF EXISTS `view_laporan_pembelian_stok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_pembelian_stok`  AS SELECT `ps`.`kode_pembelian` AS `kode_pembelian`, `ps`.`tanggal_pembelian` AS `tanggal_pembelian`, `pem`.`nama_pemasok` AS `nama_pemasok`, `sp`.`nama_part` AS `nama_part`, `dps`.`jumlah_beli` AS `jumlah_beli`, `dps`.`harga_beli_satuan` AS `harga_beli_satuan`, (`dps`.`jumlah_beli` * `dps`.`harga_beli_satuan`) AS `subtotal`, `ps`.`total_biaya_pembelian` AS `total_biaya_pembelian` FROM (((`pembelian_stok` `ps` join `pemasok` `pem` on((`ps`.`id_pemasok` = `pem`.`id_pemasok`))) join `detail_pembelian_stok` `dps` on((`ps`.`id_pembelian` = `dps`.`id_pembelian`))) join `sparepart` `sp` on((`dps`.`id_part` = `sp`.`id_part`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_pengeluaran`
--
DROP TABLE IF EXISTS `view_laporan_pengeluaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_pengeluaran`  AS SELECT 'Biaya Operasional' AS `jenis_pengeluaran`, `bo`.`tanggal_biaya` AS `tanggal`, `bo`.`nominal` AS `nominal`, `bo`.`keterangan` AS `keterangan`, `kbo`.`nama_kategori` AS `nama_kategori` FROM (`biaya_operasional` `bo` join `kategori_biaya_operasional` `kbo` on((`bo`.`id_kategori_biaya` = `kbo`.`id_kategori_biaya`)))union all select 'Gaji Mekanik' AS `jenis_pengeluaran`,`ghm`.`tanggal_bayar` AS `tanggal`,`ghm`.`nominal` AS `nominal`,`ghm`.`keterangan` AS `keterangan`,`m`.`nama_mekanik` AS `nama_mekanik` from (`gaji_harian_mekanik` `ghm` join `mekanik` `m` on((`ghm`.`id_mekanik` = `m`.`id_mekanik`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_performa_mekanik`
--
DROP TABLE IF EXISTS `view_laporan_performa_mekanik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_performa_mekanik`  AS SELECT `ts`.`kode_transaksi` AS `kode_transaksi`, `ts`.`tanggal_masuk` AS `tanggal_masuk`, `m`.`kode_mekanik` AS `kode_mekanik`, `m`.`nama_mekanik` AS `nama_mekanik`, `djs`.`harga_saat_transaksi` AS `harga_saat_transaksi`, `djs`.`biaya_tambahan` AS `biaya_tambahan` FROM ((`transaksi_servis` `ts` join `mekanik` `m` on((`ts`.`id_mekanik` = `m`.`id_mekanik`))) left join `detail_jasa_servis` `djs` on((`ts`.`id_transaksi` = `djs`.`id_transaksi`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_stok_sparepart`
--
DROP TABLE IF EXISTS `view_laporan_stok_sparepart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_stok_sparepart`  AS SELECT `sp`.`kode_part` AS `kode_part`, `sp`.`nama_part` AS `nama_part`, `kp`.`nama_kategori` AS `nama_kategori`, `mp`.`nama_merek_part` AS `nama_merek_part`, `sp`.`kualitas_part` AS `kualitas_part`, `sp`.`harga_jual` AS `harga_jual`, `sp`.`stok_saat_ini` AS `stok_saat_ini`, `sp`.`stok_minimum` AS `stok_minimum`, (case when (`sp`.`stok_saat_ini` <= `sp`.`stok_minimum`) then 'Stok Kritis' else 'Aman' end) AS `status_stok` FROM ((`sparepart` `sp` join `kategori_part` `kp` on((`sp`.`id_kategori` = `kp`.`id_kategori`))) join `merek_part` `mp` on((`sp`.`id_merek_part` = `mp`.`id_merek_part`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_transaksi_servis`
--
DROP TABLE IF EXISTS `view_laporan_transaksi_servis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hillal`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_transaksi_servis`  AS SELECT `ts`.`kode_transaksi` AS `kode_transaksi`, `ts`.`tanggal_masuk` AS `tanggal_masuk`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `k`.`nomor_plat` AS `nomor_plat`, `mm`.`nama_merek_motor` AS `nama_merek_motor`, `tm`.`nama_tipe` AS `nama_tipe`, `m`.`nama_mekanik` AS `nama_mekanik`, `ts`.`status_pengerjaan` AS `status_pengerjaan`, `ts`.`status_pembayaran` AS `status_pembayaran`, `ts`.`metode_pembayaran` AS `metode_pembayaran`, `ts`.`total_biaya` AS `total_biaya` FROM (((((`transaksi_servis` `ts` join `kendaraan` `k` on((`ts`.`id_kendaraan` = `k`.`id_kendaraan`))) join `pelanggan` `p` on((`k`.`id_pelanggan` = `p`.`id_pelanggan`))) join `tipe_motor` `tm` on((`k`.`id_tipe_motor` = `tm`.`id_tipe_motor`))) join `merek_motor` `mm` on((`tm`.`id_merek_motor` = `mm`.`id_merek_motor`))) join `mekanik` `m` on((`ts`.`id_mekanik` = `m`.`id_mekanik`))) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  ADD CONSTRAINT `fk_biaya_kategori` FOREIGN KEY (`id_kategori_biaya`) REFERENCES `kategori_biaya_operasional` (`id_kategori_biaya`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_biaya_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_jasa_servis`
--
ALTER TABLE `detail_jasa_servis`
  ADD CONSTRAINT `fk_det_jasa_master` FOREIGN KEY (`id_jasa`) REFERENCES `jasa_servis` (`id_jasa`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_jasa_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_pembelian_stok`
--
ALTER TABLE `detail_pembelian_stok`
  ADD CONSTRAINT `fk_det_beli_master` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian_stok` (`id_pembelian`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_beli_part` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_penggunaan_part`
--
ALTER TABLE `detail_penggunaan_part`
  ADD CONSTRAINT `fk_det_pakai_part` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_det_pakai_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `gaji_harian_mekanik`
--
ALTER TABLE `gaji_harian_mekanik`
  ADD CONSTRAINT `fk_gaji_mekanik` FOREIGN KEY (`id_mekanik`) REFERENCES `mekanik` (`id_mekanik`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gaji_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `jasa_luar_bubut`
--
ALTER TABLE `jasa_luar_bubut`
  ADD CONSTRAINT `fk_bubut_trans` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_servis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `fk_kendaraan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kendaraan_tipe` FOREIGN KEY (`id_tipe_motor`) REFERENCES `tipe_motor` (`id_tipe_motor`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_stok`
--
ALTER TABLE `pembelian_stok`
  ADD CONSTRAINT `fk_beli_pemasok` FOREIGN KEY (`id_pemasok`) REFERENCES `pemasok` (`id_pemasok`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_beli_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `sparepart`
--
ALTER TABLE `sparepart`
  ADD CONSTRAINT `fk_part_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_part` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_part_merek` FOREIGN KEY (`id_merek_part`) REFERENCES `merek_part` (`id_merek_part`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `tipe_motor`
--
ALTER TABLE `tipe_motor`
  ADD CONSTRAINT `fk_tipe_merek_motor` FOREIGN KEY (`id_merek_motor`) REFERENCES `merek_motor` (`id_merek_motor`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_servis`
--
ALTER TABLE `transaksi_servis`
  ADD CONSTRAINT `fk_trans_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_mekanik` FOREIGN KEY (`id_mekanik`) REFERENCES `mekanik` (`id_mekanik`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
