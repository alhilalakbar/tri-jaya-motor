<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTriggers extends Migration
{
    public function up()
    {
        $triggers = [
            <<<SQL
            CREATE TRIGGER update_total_after_delete_jasa AFTER DELETE ON detail_jasa_servis FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = OLD.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = OLD.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = OLD.id_transaksi), 0)
                ) WHERE id_transaksi = OLD.id_transaksi;
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_jasa AFTER INSERT ON detail_jasa_servis FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_update_jasa AFTER UPDATE ON detail_jasa_servis FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tambah_stok
            AFTER INSERT ON detail_pembelian_stok
            FOR EACH ROW
            BEGIN
                UPDATE sparepart
                SET stok_saat_ini = stok_saat_ini + NEW.jumlah_beli
                WHERE id_part = NEW.id_part;
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_pembelian_delete AFTER DELETE ON detail_pembelian_stok FOR EACH ROW 
            BEGIN 
                UPDATE pembelian_stok SET total_biaya_pembelian = (SELECT SUM(jumlah_beli * harga_beli_satuan) FROM detail_pembelian_stok WHERE id_pembelian = OLD.id_pembelian) WHERE id_pembelian = OLD.id_pembelian; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_pembelian_insert AFTER INSERT ON detail_pembelian_stok FOR EACH ROW 
            BEGIN 
                UPDATE pembelian_stok SET total_biaya_pembelian = (SELECT SUM(jumlah_beli * harga_beli_satuan) FROM detail_pembelian_stok WHERE id_pembelian = NEW.id_pembelian) WHERE id_pembelian = NEW.id_pembelian; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_pembelian_update AFTER UPDATE ON detail_pembelian_stok FOR EACH ROW 
            BEGIN 
                UPDATE pembelian_stok SET total_biaya_pembelian = (SELECT SUM(jumlah_beli * harga_beli_satuan) FROM detail_pembelian_stok WHERE id_pembelian = NEW.id_pembelian) WHERE id_pembelian = NEW.id_pembelian; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER cek_dan_kurangi_stok BEFORE INSERT ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                DECLARE stok_sekarang INT; 
                SET NEW.subtotal = NEW.jumlah_pakai * NEW.harga_satuan_jual;
                SELECT stok_saat_ini INTO stok_sekarang FROM sparepart WHERE id_part = NEW.id_part FOR UPDATE; 
                IF stok_sekarang < NEW.jumlah_pakai THEN 
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi'; 
                ELSE 
                    UPDATE sparepart SET stok_saat_ini = stok_saat_ini - NEW.jumlah_pakai WHERE id_part = NEW.id_part; 
                END IF; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER validasi_stok_dan_subtotal_update BEFORE UPDATE ON detail_penggunaan_part FOR EACH ROW 
            BEGIN
                DECLARE stok_sekarang INT;
                DECLARE selisih INT;
                
                IF NEW.id_part != OLD.id_part THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tidak diizinkan mengubah jenis part. Silakan hapus data ini dan input part yang baru.';
                END IF;

                SET NEW.subtotal = NEW.jumlah_pakai * NEW.harga_satuan_jual;
                
                SET selisih = NEW.jumlah_pakai - OLD.jumlah_pakai;
                
                IF selisih > 0 THEN
                    SELECT stok_saat_ini INTO stok_sekarang FROM sparepart WHERE id_part = NEW.id_part FOR UPDATE;
                    IF stok_sekarang < selisih THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk penambahan jumlah pakai';
                    END IF;
                END IF;
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER kembalikan_stok_batal AFTER DELETE ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                UPDATE sparepart SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai WHERE id_part = OLD.id_part; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_stok_part AFTER UPDATE ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                UPDATE sparepart SET stok_saat_ini = stok_saat_ini + OLD.jumlah_pakai - NEW.jumlah_pakai WHERE id_part = NEW.id_part; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_delete_part AFTER DELETE ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = OLD.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = OLD.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = OLD.id_transaksi), 0)
                ) WHERE id_transaksi = OLD.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_part AFTER INSERT ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_update_part AFTER UPDATE ON detail_penggunaan_part FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_jasa_luar BEFORE INSERT ON jasa_luar_bubut FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'jasa_luar'; SET NEW.kode_jasa_luar = CONCAT('JSL-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_jasa BEFORE INSERT ON jasa_servis FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'jasa'; SET NEW.kode_jasa = CONCAT('JSA-', LPAD(LAST_INSERT_ID(), 3, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_kategori_part BEFORE INSERT ON kategori_part FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'kategori_part'; SET NEW.kode_kategori = CONCAT('KAT-', LPAD(LAST_INSERT_ID(), 3, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_kendaraan BEFORE INSERT ON kendaraan FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'kendaraan'; SET NEW.kode_kendaraan = CONCAT('KND-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_mekanik BEFORE INSERT ON mekanik FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'mekanik'; SET NEW.kode_mekanik = CONCAT('MKN-', LPAD(LAST_INSERT_ID(), 3, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_merek_motor BEFORE INSERT ON merek_motor FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'merek_motor'; SET NEW.kode_merek_motor = CONCAT('MKT-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_merek_part BEFORE INSERT ON merek_part FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'merek_part'; SET NEW.kode_merek_part = CONCAT('MRK-', LPAD(LAST_INSERT_ID(), 3, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_pelanggan BEFORE INSERT ON pelanggan FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'pelanggan'; SET NEW.kode_pelanggan = CONCAT('PLG-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_pemasok BEFORE INSERT ON pemasok FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'pemasok'; SET NEW.kode_pemasok = CONCAT('SUP-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_pembelian BEFORE INSERT ON pembelian_stok FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'pembelian'; SET NEW.kode_pembelian = CONCAT('PUR-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_pengguna BEFORE INSERT ON pengguna FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'pengguna'; SET NEW.kode_pengguna = CONCAT('USR-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_part BEFORE INSERT ON sparepart FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'sparepart'; SET NEW.kode_part = CONCAT('PRT-', LPAD(LAST_INSERT_ID(), 5, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_tipe_motor BEFORE INSERT ON tipe_motor FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'tipe_motor'; SET NEW.kode_tipe_motor = CONCAT('TPM-', LPAD(LAST_INSERT_ID(), 3, '0')); 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER tg_kode_transaksi BEFORE INSERT ON transaksi_servis FOR EACH ROW 
            BEGIN 
                UPDATE counter_kode SET counter_value = LAST_INSERT_ID(counter_value + 1) WHERE nama_counter = 'transaksi'; SET NEW.kode_transaksi = CONCAT('TRX-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(LAST_INSERT_ID(), 4, '0')); 
            END;
            SQL,

            // TRIGGER JASA LUAR (BUBUT)
            <<<SQL
            CREATE TRIGGER update_total_after_insert_jasa_luar AFTER INSERT ON jasa_luar_bubut FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_update_jasa_luar AFTER UPDATE ON jasa_luar_bubut FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = NEW.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = NEW.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = NEW.id_transaksi), 0)
                ) WHERE id_transaksi = NEW.id_transaksi; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER update_total_after_delete_jasa_luar AFTER DELETE ON jasa_luar_bubut FOR EACH ROW 
            BEGIN 
                UPDATE transaksi_servis SET total_biaya = (
                    COALESCE((SELECT SUM(subtotal) FROM detail_penggunaan_part WHERE id_transaksi = OLD.id_transaksi), 0) + 
                    COALESCE((SELECT SUM(harga_saat_transaksi + biaya_tambahan) FROM detail_jasa_servis WHERE id_transaksi = OLD.id_transaksi), 0) +
                    COALESCE((SELECT SUM(tagihan_ke_pelanggan) FROM jasa_luar_bubut WHERE id_transaksi = OLD.id_transaksi), 0)
                ) WHERE id_transaksi = OLD.id_transaksi; 
            END;
            SQL, // <-- Koma yang terlewat ditambahkan di sini

            // TRIGGER PEMBATALAN TRANSAKSI
            <<<SQL
            CREATE TRIGGER batal_kembalikan_stok AFTER UPDATE ON transaksi_servis FOR EACH ROW 
            BEGIN 
            IF NEW.status_transaksi = 'Dibatalkan'
            AND OLD.status_transaksi IN ('Draft', 'Progress') THEN                    
            UPDATE sparepart sc JOIN detail_penggunaan_part dpp ON sc.id_part = dpp.id_part SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai WHERE dpp.id_transaksi = NEW.id_transaksi; 
                END IF; 
            END;
            SQL,

            <<<SQL
            CREATE TRIGGER rollback_stok_transaksi AFTER DELETE ON transaksi_servis FOR EACH ROW 
            BEGIN 
                UPDATE sparepart sc JOIN detail_penggunaan_part dpp ON sc.id_part = dpp.id_part SET sc.stok_saat_ini = sc.stok_saat_ini + dpp.jumlah_pakai WHERE dpp.id_transaksi = OLD.id_transaksi; 
            END;
            SQL
        ];

        foreach ($triggers as $trigger) {
            $this->db->simpleQuery($trigger);
        }
    }

    public function down()
    {
        $triggerNames = [
            'update_total_after_delete_jasa',
            'update_total_after_jasa',
            'update_total_after_update_jasa',
            'tambah_stok',
            'update_total_pembelian_delete',
            'update_total_pembelian_insert',
            'update_total_pembelian_update',
            'cek_dan_kurangi_stok',
            'validasi_stok_dan_subtotal_update',
            'kembalikan_stok_batal',
            'update_stok_part',
            'update_total_after_delete_part',
            'update_total_after_part',
            'update_total_after_update_part',
            'tg_kode_jasa_luar',
            'tg_kode_jasa',
            'tg_kode_kategori_part',
            'tg_kode_kendaraan',
            'tg_kode_mekanik',
            'tg_kode_merek_motor',
            'tg_kode_merek_part',
            'tg_kode_pelanggan',
            'tg_kode_pemasok',
            'tg_kode_pembelian',
            'tg_kode_pengguna',
            'tg_kode_part',
            'tg_kode_tipe_motor',
            'tg_kode_transaksi',
            'update_total_after_insert_jasa_luar',
            'update_total_after_update_jasa_luar',
            'update_total_after_delete_jasa_luar',
            'batal_kembalikan_stok',
            'rollback_stok_transaksi'
        ];

        foreach ($triggerNames as $name) {
            $this->db->simpleQuery("DROP TRIGGER IF EXISTS {$name}");
        }
    }
}