<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<div class="row">
    <div class="col-12">

        <div class="callout callout-info mb-3 no-print">
            <h5>
                <i class="bi bi-info-circle"></i>
                Detail Transaksi: <?= $h['kode_transaksi']; ?>
            </h5>
            Halaman ini menampilkan rincian pengerjaan servis, jasa luar, dan penggantian part.
        </div>

        <div class="invoice p-4 mb-3 shadow rounded bg-white">

            <div class="row mb-4">
                <div class="col-sm-6">
                    <h2 class="fw-bold text-primary mb-1">
                        TRI JAYA MOTOR
                    </h2>

                    <address class="mb-0">
                        <strong>Bengkel Spesialis & Sparepart</strong><br>
                        Jl. Malaka 2 No.7b, RT.3/RW.6, Rorotan<br>
                        Kec. Cilincing, Jakarta Utara 14140<br>
                        Telp: 08xx-xxxx-xxxx
                    </address>
                </div>

                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <h4 class="fw-bold">DATA PELANGGAN</h4>

                    <address>
                        <strong><?= esc($h['nama_pelanggan']); ?></strong><br>

                        <b>Plat Nomor:</b>
                        <?= esc($h['nomor_plat']); ?><br>

                        <b>Mekanik:</b>
                        <?= esc($h['nama_mekanik'] ?? '-'); ?><br>

                        <b>Tanggal:</b>
                        <?= date('d-m-Y', strtotime($h['tanggal_masuk'])); ?><br>

                        <b>Kode Transaksi:</b>
                        <?= esc($h['kode_transaksi']); ?>
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <p class="lead fw-bold">
                        Rincian Jasa Servis
                    </p>

                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Deskripsi Jasa</th>
                                <th class="text-end" style="width: 200px">
                                    Biaya
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $subJasa = 0;

                            foreach ($jasa as $j):
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= esc($j['nama_jasa']); ?>
                                    </td>

                                    <td class="text-end">
                                        Rp <?= number_format($j['harga_saat_transaksi'], 0, ',', '.'); ?>
                                    </td>
                                </tr>

                                <?php
                                $subJasa += $j['harga_saat_transaksi'];
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <?php
            $subJasaLuar = 0;
            if (isset($jasa_luar) && !empty($jasa_luar)):
                ?>
                <div class="row mt-4">
                    <div class="col-12 table-responsive">

                        <p class="lead fw-bold">
                            Rincian Jasa Luar (Bubut)
                        </p>

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Deskripsi Pekerjaan</th>
                                    <th class="text-end" style="width: 200px">
                                        Biaya
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $noJL = 1;

                                foreach ($jasa_luar as $jl):
                                    ?>
                                    <tr>
                                        <td><?= $noJL++; ?></td>

                                        <td>
                                            <?= esc($jl['deskripsi_pekerjaan']); ?>
                                        </td>

                                        <td class="text-end">
                                            Rp <?= number_format($jl['tagihan_ke_pelanggan'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>

                                    <?php
                                    $subJasaLuar += $jl['tagihan_ke_pelanggan'];
                                    ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php endif; ?>

            <!-- TABEL PART -->
            <div class="row mt-4">
                <div class="col-12 table-responsive">

                    <p class="lead fw-bold">
                        Rincian Penggantian Part
                    </p>

                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Nama Barang</th>
                                <th style="width: 100px">Qty</th>
                                <th class="text-end" style="width: 180px">
                                    Harga
                                </th>
                                <th class="text-end" style="width: 180px">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $noPart = 1;
                            $subPart = 0;

                            foreach ($part as $p):
                                ?>
                                <tr>
                                    <td><?= $noPart++; ?></td>

                                    <td>
                                        <?= esc($p['nama_part']); ?>
                                    </td>

                                    <td>
                                        <?= $p['jumlah_pakai']; ?>
                                    </td>

                                    <td class="text-end">
                                        Rp <?= number_format($p['harga_satuan_jual'], 0, ',', '.'); ?>
                                    </td>

                                    <td class="text-end">
                                        Rp <?= number_format($p['subtotal'], 0, ',', '.'); ?>
                                    </td>
                                </tr>

                                <?php
                                $subPart += $p['subtotal'];
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- TOTAL -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <p class="text-muted small">
                        * Nota ini merupakan bukti resmi transaksi servis kendaraan.<br>
                        * Sparepart yang digunakan telah otomatis mengurangi stok gudang.
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table">

                            <tr>
                                <th style="width:50%">
                                    Subtotal Jasa Servis:
                                </th>

                                <td class="text-end">
                                    Rp <?= number_format($subJasa, 0, ',', '.'); ?>
                                </td>
                            </tr>

                            <!-- Subtotal Jasa Luar hanya muncul jika ada nominalnya -->
                            <?php if ($subJasaLuar > 0): ?>
                                <tr>
                                    <th>
                                        Subtotal Jasa Luar:
                                    </th>

                                    <td class="text-end">
                                        Rp <?= number_format($subJasaLuar, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <th>
                                    Subtotal Part:
                                </th>

                                <td class="text-end">
                                    Rp <?= number_format($subPart, 0, ',', '.'); ?>
                                </td>
                            </tr>

                            <tr class="table-primary fw-bold">
                                <th>
                                    GRAND TOTAL:
                                </th>

                                <td class="text-end text-primary fs-5">
                                    Rp <?= number_format($h['total_biaya'], 0, ',', '.'); ?>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="row mt-4 no-print">
            <div class="col-12 text-end">

                <a href="<?= base_url('transaksi/servis'); ?>" class="btn btn-secondary shadow-sm">

                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button type="button" class="btn btn-primary shadow-sm" onclick="window.print()">

                    <i class="bi bi-printer"></i>
                    Cetak Nota
                </button>

            </div>
        </div>

    </div>
</div>

<!-- STYLE PRINT -->
<style>
    @media print {

        /* Hilangkan elemen admin */
        .no-print,
        .main-footer,
        .app-header,
        .app-sidebar,
        .sidebar,
        .navbar,
        .main-sidebar {
            display: none !important;
        }

        /* Full halaman */
        body,
        .wrapper,
        .content-wrapper,
        .app-main,
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background: #fff !important;
        }

        /* Rapikan invoice */
        .invoice {
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 10px !important;
        }

        /* Tabel print */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table td,
        .table th {
            padding: 8px !important;
            border: 1px solid #000 !important;
        }

        .table-dark {
            background: #000 !important;
            color: #fff !important;
        }

        /* Hindari kepotong */
        tr,
        td,
        th {
            page-break-inside: avoid !important;
        }
    }
</style>

<?= $this->endSection(); ?>