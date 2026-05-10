<?php helper('text'); ?>

<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-success p-3 rounded shadow-sm mb-4">

                <div class="inner">

                    <p class="mb-1">Omzet Hari Ini</p>

                    <h3 class="fw-bold fs-4">
                        Rp <?= number_format($omzet_hari_ini, 0, ',', '.'); ?>
                    </h3>

                    <small class="opacity-75">
                        Transaksi lunas hari ini
                    </small>

                </div>

                <div class="icon text-end opacity-25">
                    <i class="bi bi-cash-stack fs-1"></i>
                </div>

            </div>

        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-primary p-3 rounded shadow-sm mb-4">

                <div class="inner">

                    <p class="mb-1">Laba Bersih</p>

                    <h3 class="fw-bold fs-4">
                        Rp <?= number_format($laba_bersih, 0, ',', '.'); ?>
                    </h3>

                    <small class="opacity-75">
                        Setelah biaya & gaji
                    </small>

                </div>

                <div class="icon text-end opacity-25">
                    <i class="bi bi-graph-up-arrow fs-1"></i>
                </div>

            </div>

        </div>

        <div class="col-lg-2 col-6">

            <div class="small-box text-bg-warning p-3 rounded shadow-sm mb-4 text-dark">

                <div class="inner">

                    <p class="mb-1">Unit Aktif</p>

                    <h3 class="fw-bold">
                        <?= count($unit_proses); ?>
                        <small class="fs-6">Motor</small>
                    </h3>

                    <small class="opacity-75">
                        Sedang diproses
                    </small>

                </div>

                <div class="icon text-end opacity-25">
                    <i class="bi bi-tools fs-1"></i>
                </div>

            </div>

        </div>

        <div class="col-lg-2 col-6">

            <div class="small-box text-bg-danger p-3 rounded shadow-sm mb-4">

                <div class="inner">

                    <p class="mb-1">Belum Lunas</p>

                    <h3 class="fw-bold">
                        <?= $belum_lunas; ?>
                        <small class="fs-6">Transaksi</small>
                    </h3>

                    <small class="opacity-75">
                        Menunggu pembayaran
                    </small>

                </div>

                <div class="icon text-end opacity-25">
                    <i class="bi bi-exclamation-circle fs-1"></i>
                </div>

            </div>

        </div>

        <div class="col-lg-2 col-6">

            <div class="small-box text-bg-dark p-3 rounded shadow-sm mb-4">

                <div class="inner">

                    <p class="mb-1">Stok Kritis</p>

                    <h3 class="fw-bold">
                        <?= $stok_kritis_count; ?>
                        <small class="fs-6">Item</small>
                    </h3>

                    <small class="opacity-75">
                        Perlu restock
                    </small>

                </div>

                <div class="icon text-end opacity-25">
                    <i class="bi bi-box-seam fs-1"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-activity text-primary me-2"></i>
                        Monitoring Pekerjaan Mekanik
                    </h6>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-3">Plat Nomor</th>

                                    <th>Mekanik</th>

                                    <th>Keluhan Awal</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $statusColor = [
                                    'Antre' => 'text-bg-secondary',
                                    'Diproses' => 'text-bg-warning',
                                    'Menunggu Part' => 'text-bg-danger',
                                    'Selesai' => 'text-bg-success',
                                    'Diambil' => 'text-bg-primary',
                                    'Dibatalkan' => 'text-bg-dark'
                                ];
                                ?>

                                <?php foreach ($unit_proses as $up): ?>

                                    <tr>

                                        <td class="ps-3">

                                            <span class="badge text-bg-dark font-monospace">
                                                <?= $up['nomor_plat']; ?>
                                            </span>

                                        </td>

                                        <td>

                                            <?= $up['nama_mekanik'] ?? '<i class="text-muted">Belum ditentukan</i>'; ?>

                                        </td>

                                        <td>

                                            <small class="text-muted">
                                                <?= character_limiter($up['keluhan_awal'], 50); ?>
                                            </small>

                                        </td>

                                        <td>

                                            <span
                                                class="badge rounded-pill <?= $statusColor[$up['status_pengerjaan']] ?? 'text-bg-secondary'; ?> px-3">

                                                <?php if ($up['status_pengerjaan'] == 'Diproses'): ?>

                                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>

                                                <?php endif; ?>

                                                <?= esc($up['status_pengerjaan']); ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                <?php if (empty($unit_proses)): ?>

                                    <tr>

                                        <td colspan="4" class="text-center py-4 text-muted">

                                            <i class="bi bi-info-circle me-1"></i>

                                            Tidak ada pekerjaan yang sedang berlangsung.

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-pie-chart text-success me-2"></i>
                        Rincian Sumber Laba
                    </h6>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">

                        <span>Laba Jasa (Skill)</span>

                        <span class="fw-bold text-success">

                            + Rp <?= number_format($detail_laba_jasa, 0, ',', '.'); ?>

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span>Laba Sparepart (Margin)</span>

                        <span class="fw-bold text-success">

                            + Rp <?= number_format($detail_laba_part, 0, ',', '.'); ?>

                        </span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="h6 mb-0">Total Laba Kotor</span>

                        <span class="h5 mb-0 fw-bold text-primary">

                            Rp <?= number_format($laba_hari_ini, 0, ',', '.'); ?>

                        </span>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-bold">

                        <i class="bi bi-wallet2 text-danger me-2"></i>

                        Pengeluaran Hari Ini

                    </h6>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">

                        <span>Total Pengeluaran</span>

                        <span class="fw-bold text-danger">

                            - Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?>

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-2">

                        <span>Pembelian Stok Hari Ini</span>

                        <span class="fw-bold text-dark">

                            Rp <?= number_format($pembelian_hari_ini, 0, ',', '.'); ?>

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-2">

                        <span>Total Nilai Aset Gudang</span>

                        <span class="fw-bold text-primary">

                            Rp <?= number_format($total_aset_gudang, 0, ',', '.'); ?>

                        </span>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm border-0 bg-light p-3">

                <div class="d-flex align-items-center">

                    <i class="bi bi-person-badge fs-2 text-secondary me-3"></i>

                    <div>

                        <p class="mb-0 small text-muted">
                            Login sebagai:
                        </p>

                        <h6 class="mb-0 fw-bold">

                            <?= session()->get('nama_pengguna'); ?>
                            (<?= session()->get('peran'); ?>)

                        </h6>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>