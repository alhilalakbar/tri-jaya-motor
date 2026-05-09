<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="callout callout-dark mb-3">
            <h5><i class="bi bi-cart-check-fill"></i> Detail Pembelian Stok: <?= $h['kode_pembelian']; ?></h5>
            Halaman ini menampilkan rincian barang yang dibeli dari pemasok untuk menambah stok gudang.
        </div>

        <div class="row mb-4">
            <div class="col-sm-6">
                <h4 class="text-dark fw-bold"><i class="bi bi-box-seam"></i> TRI JAYA MOTOR</h4>
                <address>
                    <strong>Bagian Gudang & Logistik</strong><br>
                    Jl. Malaka 2 No.7b, RT.3/RW.6, Rorotan<br>
                    Kec. Cilincing, Jkt Utara, Jakarta 14140<br>
                    Sistem Operasional Bengkel Tri Jaya Motor Rorotan<br>
                </address>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h5 class="fw-bold">DATA TOKO / PEMASOK</h5>
                <address>
                    <strong class="text-primary"><?= esc($h['nama_pemasok']); ?></strong><br>
                    <b>Kode Pembelian:</b> <?= $h['kode_pembelian']; ?><br>
                    <b>Tanggal Masuk:</b> <?= date('d/m/Y', strtotime($h['tanggal_pembelian'])); ?><br>
                    <b>Status:</b> <span class="badge text-bg-success">Selesai / Masuk Stok</span>
                </address>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 table-responsive">
                <p class="lead fw-bold">Daftar Item Sparepart</p>
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Nama Barang / Sparepart</th>
                            <th class="text-center" style="width: 100px">Jumlah</th>
                            <th class="text-end" style="width: 200px">Harga Beli Satuan</th>
                            <th class="text-end" style="width: 200px">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($items as $i): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($i['nama_part']); ?></td>
                                <td class="text-center"><?= $i['jumlah']; ?></td>
                                <td class="text-end">Rp <?= number_format($i['harga_beli'], 0, ',', '.'); ?></td>
                                <td class="text-end">Rp <?= number_format($i['jumlah'] * $i['harga_beli'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td colspan="4" class="text-end">TOTAL PEMBELIAN :</td>
                            <td class="text-end text-primary" style="font-size: 1.2rem;">
                                Rp <?= number_format($h['total_harga'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row mt-5 no-print">
            <div class="col-md-6">
                <p class="text-muted small">
                    * Catatan: Data ini merupakan arsip digital dari transaksi pembelian stok barang.<br>
                    * Stok barang yang tertera telah otomatis ditambahkan ke database persediaan.
                </p>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?= base_url('backend/transaksi/pembelian'); ?>" class="btn btn-secondary shadow-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
                <button type="button" class="btn btn-dark shadow-sm" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak Bukti Masuk
                </button>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    @media print {

        .no-print,
        .main-footer,
        .app-header,
        .app-sidebar {
            display: none !important;
        }

        .content-wrapper,
        .app-main {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .invoice {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
<?= $this->endSection(); ?>