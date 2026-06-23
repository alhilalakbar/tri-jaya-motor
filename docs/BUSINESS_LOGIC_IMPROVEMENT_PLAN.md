# Business Logic Improvement Plan

## Sistem Operasional Bengkel Tri Jaya Motor

### Tujuan

Dokumen ini dibuat sebagai catatan pengembangan (development notes) yang berisi evaluasi terhadap implementasi logika bisnis saat ini beserta daftar penyempurnaan yang perlu dilakukan pada iterasi berikutnya.

Dokumen ini berfungsi sebagai pengingat sekaligus acuan pengembangan agar perubahan yang dilakukan tetap konsisten dengan proses bisnis bengkel.

---

# 1. Mekanisme Status Transaksi

## Permasalahan

Transaksi yang telah dibuat tidak dapat diubah, sehingga tidak mendukung kondisi operasional ketika pelanggan menambahkan jasa servis atau penggunaan sparepart sebelum proses pembayaran selesai.

## Target Perbaikan

* [ ] Transaksi dengan status **Belum Lunas** masih dapat diedit.
* [ ] Transaksi dengan status **Lunas** dikunci dan tidak dapat diubah.
* [ ] Menjaga konsistensi histori transaksi setelah pembayaran dilakukan.

---

# 2. Mekanisme Edit Transaksi

## Permasalahan

Sistem belum mendukung perubahan isi transaksi selama proses servis berlangsung.

## Target Perbaikan

* [ ] Menambah jasa servis sebelum transaksi lunas.
* [ ] Menambah penggunaan sparepart sebelum transaksi lunas.
* [ ] Mengurangi atau menghapus item transaksi sebelum transaksi lunas.
* [ ] Memastikan total transaksi diperbarui secara otomatis.

---

# 3. Konsep Harga Master Sparepart

## Permasalahan

Harga pada master sparepart masih berpotensi digunakan sebagai referensi histori transaksi.

## Target Perbaikan

* [ ] Menjadikan harga pada master sparepart sebagai **harga jual default (pricelist)**.
* [ ] Perubahan harga hanya berlaku untuk transaksi baru.
* [ ] Perubahan harga tidak memengaruhi histori transaksi yang sudah tersimpan.

---

# 4. Histori Harga Transaksi

## Permasalahan

Histori transaksi harus bersifat tetap dan tidak bergantung pada perubahan data master.

## Target Perbaikan

* [ ] Menyimpan harga jual pada detail transaksi saat transaksi dibuat.
* [ ] Menjadikan detail transaksi sebagai sumber histori harga.
* [ ] Menjamin histori transaksi bersifat immutable.

---

# 5. Logika Perhitungan Keuntungan

## Permasalahan

Perhitungan keuntungan harus merepresentasikan kondisi transaksi pada saat transaksi terjadi.

## Target Perbaikan

* [ ] Menggunakan harga jual transaksi.
* [ ] Menggunakan harga beli historis.
* [ ] Menghilangkan ketergantungan terhadap harga pada master sparepart.

---

# 6. Audit Laporan Keuangan

## Target Audit

* [ ] Validasi omzet.
* [ ] Validasi laba kotor.
* [ ] Validasi laba bersih.
* [ ] Memastikan seluruh laporan menggunakan histori transaksi sebagai sumber data utama.
* [ ] Memastikan perubahan data master tidak memengaruhi histori laporan.

---

# 7. Audit Mekanisme Pengelolaan Stok

## Target Audit

- [ ] Pembelian menambah stok secara otomatis.
- [ ] Penggunaan sparepart mengurangi stok secara otomatis.
- [ ] Pembatalan transaksi mengembalikan stok ke kondisi semula.
- [ ] Memastikan jumlah stok selalu sesuai dengan kondisi riil.
- [ ] Menghindari perubahan stok akibat penghapusan data secara langsung.

---

# Catatan

Dokumen ini bukan daftar bug, melainkan daftar penyempurnaan hasil evaluasi implementasi sistem.

Seluruh perubahan dilakukan dengan tujuan:

* meningkatkan konsistensi data,
* menjaga integritas histori transaksi,
* meningkatkan akurasi laporan keuangan,
* dan menyesuaikan sistem dengan proses bisnis operasional Bengkel Tri Jaya Motor.

> Prinsip utama yang harus selalu diingat:
>
> **Master data merepresentasikan kondisi saat ini (current state), sedangkan data transaksi merepresentasikan fakta yang telah terjadi (historical state). Histori transaksi tidak boleh berubah akibat perubahan data master.**
