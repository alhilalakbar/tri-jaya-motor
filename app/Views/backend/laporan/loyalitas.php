<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<!-- Tombol Export -->
<div class="btn-group ms-2 mb-3">
    <a href="<?= base_url('laporan/export/excel/loyalitas?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-success shadow-sm">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>

    <a href="<?= base_url('laporan/export/pdf/loyalitas?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-danger shadow-sm">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

<!-- Card Laporan -->
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header">
        <h5 class="card-title m-0"><?= $judul; ?></h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-nowrap" id="tableLoyalitas">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Frekuensi Servis</th>
                        <th>Total Pengeluaran</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($laporan as $l): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $l->nama_pelanggan; ?></strong></td>
                        <td class="text-center"><?= $l->frekuensi_servis; ?> kali</td>
                        <td class="text-end">
                            Rp <?= number_format($l->total_pengeluaran, 0, ',', '.'); ?>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                <?= $l->kategori_loyalitas; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tableLoyalitas').DataTable({
        responsive: false,
        scrollX: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>

<?= $this->endSection(); ?>