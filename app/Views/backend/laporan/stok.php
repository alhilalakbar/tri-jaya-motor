<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form action="<?= base_url('backend/laporan/stok'); ?>" method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-secondary">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-secondary">Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
            </div>
            <div class="col-md-6">
                <div class="btn-group me-2">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="bi bi-filter"></i> Filter</button>
                    <a href="<?= base_url('backend/laporan/stok'); ?>" class="btn btn-secondary shadow-sm"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('today')">Hari Ini</button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('month')">Bulan Ini</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mb-3">
    <div class="btn-group">
        <a href="<?= base_url('backend/laporan/export/excel/stok?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>" 
           class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>

        <a href="<?= base_url('backend/laporan/export/pdf/stok?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>" 
           class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="card card-primary card-outline shadow-sm">
    <div class="card-header">
        <h5 class="card-title m-0"><?= $judul; ?></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-nowrap" id="tableStok">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Sparepart</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($laporan as $l): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="badge text-bg-dark"><?= $l->kode_part; ?></span></td>
                        <td><?= $l->nama_part; ?></td>
                        <td><?= $l->nama_kategori; ?></td>
                        <td><?= $l->nama_merek_part; ?></td>
                        <td class="text-center"><?= $l->stok_saat_ini; ?></td>
                        <td class="text-end">Rp <?= number_format($l->harga_jual, 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge bg-<?= $l->status_stok == 'Aman' ? 'success' : 'danger'; ?>">
                                <?= $l->status_stok; ?>
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
function setRange(type) {
    const startInput = document.getElementById('tgl_mulai');
    const endInput = document.getElementById('tgl_akhir');
    const now = new Date();
    const dateStr = now.toISOString().split('T')[0];

    if (type === 'today') {
        startInput.value = dateStr;
        endInput.value = dateStr;
    } else if (type === 'month') {
        const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 2).toISOString().split('T')[0];
        startInput.value = startOfMonth;
        endInput.value = dateStr;
    }
}

$(document).ready(function() {
    $('#tableStok').DataTable({
        "responsive": false,
        "scrollX": true,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"f>rtip', // Hapus 'B' jika tombol export sudah ada di atas manual
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>

<?= $this->endSection(); ?>