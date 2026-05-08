<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="callout callout-info mb-3">
            <h5><i class="bi bi-info-circle"></i> Detail Transaksi: <?= $h['kode_transaksi']; ?></h5>
            Halaman ini menampilkan rincian pengerjaan servis dan penggantian part.
        </div>

        <div class="invoice p-3 mb-3 shadow-sm rounded">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h4 class="text-primary fw-bold">TRI JAYA MOTOR</h4>
                    <address>
                        <strong>Bengkel Spesialis & Sparepart</strong><br>
                        Jl. Malaka 2 No.7b, RT.3/RW.6, Rorotan<br>
                        Kec. Cilincing, Jakarta Utara 14140<br>
                        Telp: 08xx-xxxx-xxxx
                    </address>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <h5 class="fw-bold">DATA PELANGGAN</h5>
                    <b>Nama:</b> <?= $h['nama_pelanggan']; ?><br>
                    <b>Plat Nomor:</b> <?= $h['nomor_plat']; ?><br>
                    <b>Mekanik:</b> <?= $h['nama_mekanik'] ?? '-'; ?><br>
                    <b>Tanggal:</b> <?= date('d-m-Y', strtotime($h['tanggal_masuk'])); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 table-responsive">
                <p class="lead fw-bold">Rincian Jasa Servis</p>
                <table class="table table-striped table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Deskripsi Jasa</th>
                            <th class="text-end">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $subJasa = 0;
                        foreach ($jasa as $j): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $j['nama_jasa']; ?></td>
                                <td class="text-end">Rp <?= number_format($j['harga_saat_transaksi'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                            <?php $subJasa += $j['harga_saat_transaksi']; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 table-responsive">
                <p class="lead fw-bold">Rincian Penggantian Part</p>
                <table class="table table-striped table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $subPart = 0;
                        foreach ($part as $p): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $p['nama_part']; ?></td>
                                <td><?= $p['jumlah_pakai']; ?></td>
                                <td class="text-end">Rp <?= number_format($p['harga_satuan_jual'], 0, ',', '.'); ?></td>
                                <td class="text-end">Rp <?= number_format($p['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php $subPart += $p['subtotal']; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6"></div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal Jasa:</th>
                            <td class="text-end">Rp <?= number_format($subJasa, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Subtotal Part:</th>
                            <td class="text-end">Rp <?= number_format($subPart, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="table-primary">
                            <th>GRAND TOTAL:</th>
                            <td class="text-end text-primary fw-bold">Rp
                                <?= number_format($h['total_biaya'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row no-print mt-3">
            <div class="col-12 text-end">
                <a href="<?= base_url('backend/transaksi/servis'); ?>" class="btn btn-secondary"><i
                        class="bi bi-arrow-left"></i> Kembali</a>
                <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer"></i>
                    Cetak Nota</button>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>