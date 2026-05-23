<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<!-- Filter Tanggal -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form action="<?= base_url('laporan/laba-rugi'); ?>" method="get" class="row g-3 align-items-end">
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
                    <a href="<?= base_url('laporan/laba-rugi'); ?>" class="btn btn-secondary shadow-sm"><i
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
    <a href="<?= base_url('laporan/export/excel/laba-rugi?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-success shadow-sm">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>

    <a href="<?= base_url('laporan/export/pdf/laba-rugi?tgl_mulai=' . $tgl_mulai . '&tgl_akhir=' . $tgl_akhir); ?>"
        class="btn btn-danger shadow-sm">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

<div class="card card-primary card-outline shadow-sm">
    <div class="card-header">
        <h5 class="card-title m-0"><?= $judul; ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <table class="table table-bordered align-middle shadow-sm">
                    <tr>
                        <th class="bg-light" style="width: 300px;">Total Pendapatan (Servis & Part)</th>
                        <td class="text-end text-success"><strong>Rp
                                <?= number_format($laba->total_pendapatan, 0, ',', '.'); ?></strong></td>
                    </tr>
                    <tr>
                        <th class="bg-light">HPP Sparepart (Modal Barang Terjual)</th>
                        <td class="text-end text-danger">Rp <?= number_format($laba->total_hpp, 0, ',', '.'); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Total Biaya Operasional</th>
                        <td class="text-end text-danger">Rp <?= number_format($laba->total_operasional, 0, ',', '.'); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Total Gaji Mekanik</th>
                        <td class="text-end text-danger">Rp <?= number_format($laba->total_gaji, 0, ',', '.'); ?></td>
                    </tr>
                    <tr class="table-primary border-primary">
                        <th class="py-3">ESTIMASI LABA BERSIH</th>
                        <td class="text-end py-3">
                            <h4 class="m-0 text-primary"><strong>Rp
                                    <?= number_format($laba->estimasi_laba_bersih, 0, ',', '.'); ?></strong></h4>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <div class="alert alert-info border-0 shadow-sm h-100">
                    <h5 class="fw-bold"><i class="bi bi-info-circle-fill"></i> Ringkasan Laporan</h5>
                    <hr>
                    <p class="small">Laporan ini menggunakan data <strong>real-time</strong> berdasarkan transaksi yang
                        sudah lunas.</p>
                    <ul class="small">
                        <li><strong>Pendapatan:</strong> Total harga jual jasa & part.</li>
                        <li><strong>HPP:</strong> Modal dari part yang laku saja.</li>
                        <li><strong>Laba Bersih:</strong> Keuntungan bersih setelah biaya operasional.</li>
                    </ul>
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
        </script>
    </div>
</div>

<?= $this->endSection(); ?>