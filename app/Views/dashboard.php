<?php helper('text'); ?>
<?= $this->extend('backend/layout/admin_layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary p-3 rounded shadow-sm mb-4">
                <div class="inner">
                    <p class="mb-1">Estimasi Laba Hari Ini</p>
                    <h3 class="fw-bold">Rp <?= number_format($laba_hari_ini, 0, ',', '.'); ?></h3>
                    <small class="opacity-75">Gabungan Jasa & Margin Part</small>
                </div>
                <div class="icon text-end opacity-25"><i class="bi bi-graph-up-arrow fs-1"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning p-3 rounded shadow-sm mb-4 text-dark">
                <div class="inner">
                    <p class="mb-1">Unit Sedang Diproses</p>
                    <h3 class="fw-bold"><?= count($unit_proses); ?> <small class="fs-6">Motor</small></h3>
                    <small class="opacity-75">Mekanik sedang bekerja</small>
                </div>
                <div class="icon text-end opacity-25"><i class="bi bi-gear-wide-connected fs-1"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger p-3 rounded shadow-sm mb-4">
                <div class="inner">
                    <p class="mb-1">Stok Perlu Order</p>
                    <h3 class="fw-bold"><?= $stok_kritis_count; ?> <small class="fs-6">Item</small></h3>
                    <small class="opacity-75">Di bawah batas minimum</small>
                </div>
                <div class="icon text-end opacity-25"><i class="bi bi-exclamat-triangle-fill fs-1"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-dark p-3 rounded shadow-sm mb-4">
                <div class="inner">
                    <p class="mb-1">Total Nilai Aset</p>
                    <h3 class="fw-bold">Rp <?= number_format($total_aset_gudang, 0, ',', '.'); ?></h3>
                    <small class="opacity-75">Berdasarkan Harga Modal</small>
                </div>
                <div class="icon text-end opacity-25"><i class="bi bi-box-seam fs-1"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-activity text-primary me-2"></i> Monitoring Pekerjaan
                        Mekanik</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Plat Nomor</th>
                                    <th>Mekanik</th>
                                    <th>Keluhan Awal</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unit_proses as $up): ?>
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge text-bg-dark font-monospace"><?= $up['nomor_plat']; ?></span>
                                    </td>
                                    <td><?= $up['nama_mekanik'] ?? '<i class="text-muted">Belum ditentukan</i>'; ?></td>
                                    <td><small
                                            class="text-muted"><?= character_limiter($up['keluhan_awal'], 50); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill text-bg-warning px-3">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Diproses
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($unit_proses)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Tidak ada pekerjaan yang sedang
                                        berlangsung.
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
                    <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart text-success me-2"></i> Rincian Sumber Laba</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Laba Jasa (Skill)</span>
                        <span class="fw-bold text-success">+ Rp
                            <?= number_format($detail_laba_jasa, 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Laba Sparepart (Margin)</span>
                        <span class="fw-bold text-success">+ Rp
                            <?= number_format($detail_laba_part, 0, ',', '.'); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h6 mb-0">Total Laba Kotor</span>
                        <span class="h5 mb-0 fw-bold text-primary">Rp
                            <?= number_format($laba_hari_ini, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-light p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-badge fs-2 text-secondary me-3"></i>
                    <div>
                        <p class="mb-0 small text-muted">Login sebagai:</p>
                        <h6 class="mb-0 fw-bold"><?= session()->get('nama_pengguna'); ?>
                            (<?= session()->get('peran'); ?>)</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>