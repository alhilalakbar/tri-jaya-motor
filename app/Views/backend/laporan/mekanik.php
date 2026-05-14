<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<!-- Filter Tanggal -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form action="<?= base_url('backend/laporan/mekanik'); ?>" method="get" class="row g-3 align-items-end">
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
                    <a href="<?= base_url('backend/laporan/mekanik'); ?>" class="btn btn-secondary shadow-sm"><i
                            class="bi bi-arrow-clockwise"></i> Reset</a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('today')">Hari
                        Ini</button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setRange('month')">Bulan
                        Ini</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="btn-group ms-2">
    <a href="<?= base_url('backend/laporan/export/excel/mekanik?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-success shadow-sm">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>

    <a href="<?= base_url('backend/laporan/export/pdf/mekanik?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-danger shadow-sm">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

<div class="card card-primary card-outline shadow-sm">
    <div class="card-header">
        <h5 class="card-title m-0"><?= $judul; ?></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-nowrap" id="tableMekanik">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Mekanik</th>
                        <th>Total Servis</th>
                        <th>Pendapatan Jasa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($laporan as $l): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $l->nama_mekanik; ?></strong></td>
                        <td class="text-center"><?= $l->total_servis; ?></td>
                        <td class="text-end">Rp <?= number_format($l->total_pendapatan_jasa, 0, ',', '.'); ?></td>
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
            $('#tableMekanik').DataTable({
                "responsive": false,
                "scrollX": true,
                "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
                "buttons": [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success btn-sm me-1',
                        text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
                        title: 'Laporan Performa Mekanik - ' + $('#tgl_mulai').val() + '_' + $(
                            '#tgl_akhir').val()
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        title: 'Laporan Performa Mekanik',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
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