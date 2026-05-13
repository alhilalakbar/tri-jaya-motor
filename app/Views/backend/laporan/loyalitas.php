<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<div class="card card-primary card-outline shadow-sm">
    <div class="card-header"><h5 class="card-title m-0"><?= $judul; ?></h5></div>
    <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-nowrap" id="tableLoyalitas">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Nama Pelanggan</th><th>Frekuensi Servis</th><th>Total Pengeluaran</th><th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $l): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= $l->nama_pelanggan; ?></strong></td>
                <td class="text-center"><?= $l->frekuensi_servis; ?> kali</td>
                <td class="text-end">Rp <?= number_format($l->total_pengeluaran, 0, ',', '.'); ?></td>
                <td><span class="badge bg-primary"><?= $l->kategori_loyalitas; ?></span></td>
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
        $('#tableLoyalitas').DataTable({
            "responsive": false,
            "scrollX": true,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-success btn-sm me-1',
                    text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
                    title: 'Laporan Loyalitas - ' + $('#tgl_mulai').val() + '_' + $('#tgl_akhir').val()
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-danger btn-sm',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    title: 'Laporan Loyalitas',
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