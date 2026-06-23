<?= $this->extend('backend/layout/admin_layout'); ?>
<?= $this->section('content'); ?>

<?php $peran = session()->get('peran'); ?>

<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Riwayat Servis Bengkel</h5>

        <?php if (in_array($peran, ['Admin', 'Pemilik'])): ?>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahServis()">
            <i class="bi bi-plus-lg"></i> Transaksi Baru
        </button>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <table id="tableHistory" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Transaksi / Admin</th>
                    <th>Tanggal</th>
                    <th>Kendaraan & Keluhan</th>
                    <th>Status Pengerjaan</th>
                    <th>Pembayaran</th>
                    <th>Total Biaya</th>
                    <th style="width: 80px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $d): ?>
                <tr>
                    <td>
                        <span class="fw-bold text-primary">
                            <?= $d['kode_transaksi']; ?>
                        </span><br>

                        <small class="text-muted">
                            <i class="bi bi-person"></i>
                            Input: <?= esc($d['nama_pengguna'] ?? ''); ?>
                        </small>
                    </td>

                    <td>
                        <div class="fw-semibold">
                            <?= date('d/m/Y', strtotime($d['tanggal_masuk'])); ?>
                        </div>

                        <small class="text-muted">
                            <?= date('H:i:s', strtotime($d['tanggal_masuk'])); ?>
                        </small>
                    </td>

                    <td>
                        <strong>
                            <?= esc($d['nomor_plat']); ?>
                            (<?= esc($d['nama_pelanggan']); ?>)
                        </strong><br>

                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;"
                            title="<?= esc($d['keluhan_awal']); ?>">
                            K: <?= esc($d['keluhan_awal'] ?: '-'); ?>
                        </small>
                    </td>

                    <td>
                        <?php
                            $statusColor = [
                                'Antre' => 'bg-secondary',
                                'Diproses' => 'bg-info',
                                'Menunggu Part' => 'bg-warning text-dark',
                                'Selesai' => 'bg-success',
                                'Diambil' => 'bg-primary',
                                'Dibatalkan' => 'bg-danger'
                            ];
                    ?>

                        <span class="badge <?= $statusColor[$d['status_pengerjaan']] ?? 'bg-secondary'; ?>">
                            <?= $d['status_pengerjaan'] ?: 'Antre'; ?>
                        </span><br>

                        <small class="text-muted">
                            Mek: <?= esc($d['nama_mekanik'] ?? '-'); ?>
                        </small>
                    </td>

                    <td>
                        <span class="badge <?= $d['status_pembayaran'] === 'Lunas'
                            ? 'text-success border border-success'
                            : 'text-danger border border-danger'; ?>">
                            <?= $d['status_pembayaran']; ?>
                        </span><br>

                        <small class="text-muted">
                            <?= $d['metode_pembayaran']; ?>
                        </small>
                    </td>

                    <td class="fw-bold">
                        Rp <?= number_format($d['total_biaya'], 0, ',', '.'); ?>
                    </td>

                    <td class="text-center">
                        <div class="btn-group" role="group">

                            <a href="<?= base_url('transaksi/servis/detail/' . $d['id_transaksi']); ?>"
                                class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            <?php if (
            $d['status_pengerjaan'] !== 'Selesai' &&
            $d['status_pembayaran'] !== 'Lunas'
        ): ?>
                            <a href="<?= base_url('transaksi/servis/edit/' . $d['id_transaksi']); ?>"
                                class="btn btn-warning btn-sm" title="Edit Detail Transaksi">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php else: ?>
                            <span class="btn btn-secondary btn-sm disabled" title="Transaksi sudah terkunci">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <?php endif; ?>

                            <button type="button" class="btn btn-warning btn-sm"
                                onclick='editStatus(<?= json_encode($d); ?>)' title="<?= $peran === 'Mekanik'
                ? 'Update Status'
                : 'Update Status / Pembayaran'; ?>">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL CREATE -->
<?php if (in_array($peran, ['Admin', 'Pemilik'])): ?>
<div class="modal fade" id="modalServis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('transaksi/servis/create'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-wrench-adjustable"></i>
                        Input Transaksi Servis Baru
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    <?= $this->include('backend/transaksi/servis/form'); ?>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        Simpan Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- MODAL EDIT STATUS -->
<div class="modal fade" id="modalEditStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url(
            $peran === 'Mekanik'
                ? 'transaksi/servis/update-status'
                : 'transaksi/servis/update-pembayaran'
        ); ?>" method="post">
            <?= csrf_field(); ?>

            <input type="hidden" name="id_transaksi" id="edit_id_transaksi">

            <div class="modal-content shadow-lg">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i>
                        Update Status Transaksi
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <?php if ($peran === 'Mekanik'): ?>

                    <div class="mb-3">

                        <label class="form-label">
                            Status Pengerjaan
                        </label>

                        <select name="status_pengerjaan" id="edit_status_pengerjaan" class="form-select">

                            <option value="Antre">Antre</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Menunggu Part">Menunggu Part</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Diambil">Diambil</option>
                            <option value="Dibatalkan">Dibatalkan</option>

                        </select>

                    </div>

                    <?php else: ?>

                    <div class="mb-3">

                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <select name="metode_pembayaran" id="edit_metode_pembayaran" class="form-select">

                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Dana">Dana</option>
                            <option value="BRI">BRI</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status Pembayaran
                        </label>

                        <select name="status_pembayaran" id="edit_status_pembayaran" class="form-select">

                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>

                        </select>

                    </div>

                    <?php endif; ?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-warning">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let modalServis = null;
let modalEditStatus = null;

document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        modalEditStatus = new bootstrap.Modal(document.getElementById('modalEditStatus'));

        <?php if (in_array($peran, ['Admin', 'Pemilik'])): ?>
        modalServis = new bootstrap.Modal(document.getElementById('modalServis'));
        <?php endif; ?>
    }
});

function tambahServis() {
    if (modalServis) {
        modalServis.show();
    }
}

function editStatus(data) {
    document.getElementById('edit_id_transaksi').value = data.id_transaksi;
    document.getElementById('edit_status_pengerjaan').value = data.status_pengerjaan;

    <?php if (in_array($peran, ['Admin', 'Pemilik'])): ?>
    document.getElementById('edit_metode_pembayaran').value = data.metode_pembayaran;
    document.getElementById('edit_status_pembayaran').value = data.status_pembayaran;
    <?php endif; ?>

    modalEditStatus.show();
}

function editStatus(data) {

    document.getElementById('edit_id_transaksi').value =
        data.id_transaksi;

    <?php if ($peran === 'Mekanik'): ?>

    document.getElementById('edit_status_pengerjaan').value =
        data.status_pengerjaan;

    <?php else: ?>

    document.getElementById('edit_metode_pembayaran').value =
        data.metode_pembayaran;

    document.getElementById('edit_status_pembayaran').value =
        data.status_pembayaran;

    <?php endif; ?>

    modalEditStatus.show();
}
</script>

<?= $this->endSection(); ?>