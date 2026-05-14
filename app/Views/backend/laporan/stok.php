<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

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
                        <td><span
                                class="badge bg-<?= $l->status_stok == 'Aman' ? 'success' : 'danger'; ?>"><?= $l->status_stok; ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="btn-group ms-2">
            <a href="<?= base_url('backend/laporan/export/excel/stok'); ?>" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>

            <a href="<?= base_url('backend/laporan/export/pdf/stok?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
                class="btn btn-danger shadow-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
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
                "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
                "buttons": [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success btn-sm me-1',
                        text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
                        title: 'Laporan Stok - ' + $('#tgl_mulai').val() + '_' + $('#tgl_akhir')
                            .val()
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        title: 'Laporan Stok',
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