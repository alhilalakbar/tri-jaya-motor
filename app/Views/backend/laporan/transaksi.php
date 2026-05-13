<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<!-- Filter Tanggal -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form action="<?= base_url('backend/laporan/transaksi'); ?>" method="get" class="row g-3 align-items-end">
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
                    <a href="<?= base_url('backend/laporan/transaksi'); ?>" class="btn btn-secondary shadow-sm"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('today')">Hari Ini</button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('month')">Bulan Ini</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-primary card-outline shadow-sm">
    <div class="card-header"><h5 class="card-title m-0"><?= $judul; ?></h5></div>
    <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-nowrap" id="tableTransaksi">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Kode</th><th>Tanggal</th><th>Pelanggan</th><th>No. Plat</th><th>Kendaraan</th><th>Mekanik</th><th>Status</th><th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $l): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><span class="badge text-bg-dark"><?= $l->kode_transaksi; ?></span></td>
                <td><?= date('d/m/Y H:i', strtotime($l->tanggal_masuk)); ?></td>
                <td><?= $l->nama_pelanggan; ?></td>
                <td><span class="badge text-bg-secondary"><?= $l->nomor_plat; ?></span></td>
                <td><?= $l->nama_merek_motor; ?> <?= $l->nama_tipe; ?></td>
                <td><?= $l->nama_mekanik; ?></td>
                <td><span class="badge bg-success"><?= $l->status_pembayaran; ?></span></td>
                <td class="text-end">Rp <?= number_format($l->total_biaya, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
        $('#tableTransaksi').DataTable({
            "responsive": false,
            "scrollX": true,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-success btn-sm me-1',
                    text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
                    title: 'Laporan Transaksi - ' + $('#tgl_mulai').val() + '_' + $('#tgl_akhir').val()
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-danger btn-sm',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    title: 'Laporan Transaksi',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 9;
                    }
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
</div>
</div>

<?= $this->endSection(); ?>