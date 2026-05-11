<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #F3F4F6 !important;
        color: #111827 !important;
    }

    .card {
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .border-amber {
        border-left: 6px solid #F59E0B !important;
    }

    .border-green {
        border-left: 6px solid #16A34A !important;
    }

    .border-blue {
        border-left: 6px solid #2563EB !important;
    }

    .border-red {
        border-left: 6px solid #DC2626 !important;
    }

    .border-cyan {
        border-left: 6px solid #0EA5E9 !important;
    }

    .border-secondary {
        border-left: 6px solid #64748b !important;
    }

    .text-dark-pekat {
        color: #111827 !important;
    }

    .text-muted-custom {
        color: #6B7280 !important;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .spin-icon {
        display: inline-block;
        animation: spin 2s linear infinite;
    }

    @keyframes tilt {

        0%,
        100% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(15deg);
        }
    }

    .tilt-icon {
        display: inline-block;
        animation: tilt 1s ease-in-out infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    .blink-icon {
        animation: blink 1.5s infinite;
    }

    @keyframes pulse-status {
        0% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
        }

        70% {
            box-shadow: 0 0 0 8px rgba(245, 158, 11, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
        }
    }

    .status-active-pulse {
        animation: pulse-status 2s infinite;
    }
</style>

<div class="container-fluid py-3">

    <div class="row mb-4 align-items-end">
        <div class="col-md-5">
            <h1 class="fw-bold mb-0 text-dark-pekat display-5" id="live-clock">00:00:00</h1>
            <p class="text-dark-pekat fw-bold mb-0">
                <i class="bi bi-calendar3 me-2 text-primary"></i><?= date('l, d F Y', strtotime($tanggal_mulai)); ?>
            </p>
        </div>

        <div class="col-md-7 text-end">
            <form action="" method="GET" class="d-inline-flex gap-2">
                <div class="input-group input-group-sm w-auto shadow-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>

                    <input type="date" name="tgl_mulai" class="form-control"
                        value="<?= $tanggal_mulai ?>">

                    <span class="input-group-text bg-white">s/d</span>

                    <input type="date" name="tgl_selesai" class="form-control"
                        value="<?= $tanggal_selesai ?>">

                    <button type="submit" class="btn btn-primary"
                        style="background-color: #2563EB;">
                        FILTER
                    </button>
                </div>

                <div class="btn-group btn-group-sm shadow-sm">
                    <a href="?periode=harian"
                        class="btn <?= $periode == 'harian' ? 'btn-dark' : 'btn-outline-dark' ?>">
                        HARI INI
                    </a>

                    <a href="?periode=bulanan"
                        class="btn <?= $periode == 'bulanan' ? 'btn-dark' : 'btn-outline-dark' ?>">
                        BULAN INI
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4 g-3">

        <div class="col-lg-5">
            <div class="row g-3 h-100">

                <div class="col-5">
                    <div class="card h-100 border-amber shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">

                            <h1 style="font-size: 4rem; line-height: 1; color: #F59E0B;"
                                class="fw-bold mb-1">
                                <?= count($unit_proses); ?>
                            </h1>

                            <p class="fw-bold text-uppercase mb-0 text-muted-custom"
                                style="font-size: 0.75rem;">
                                On Process
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-7 d-flex flex-column gap-3">

                    <div class="card border-green flex-fill p-3 shadow-sm d-flex flex-column justify-content-center">

                        <h3 class="fw-bold mb-0 text-truncate" style="color: #16A34A;">
                            Rp <?= number_format($omzet, 0, ',', '.'); ?>
                        </h3>

                        <small class="text-muted-custom fw-bold text-uppercase"
                            style="font-size: 0.7rem;">
                            Omzet
                        </small>

                    </div>

                    <div class="card border-secondary flex-fill p-3 shadow-sm d-flex flex-column justify-content-center">

                        <h4 class="fw-bold mb-0 text-dark-pekat">
                            <?= $total_transaksi; ?>
                        </h4>

                        <small class="text-muted-custom fw-bold text-uppercase"
                            style="font-size: 0.7rem;">
                            Total Transaksi
                        </small>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-3">

            <div class="card border-blue mb-3 py-3 text-center h-50 shadow-sm"
                style="border-left: 6px solid <?= $laba_color; ?> !important;">

                <div class="card-body d-flex flex-column justify-content-center">

                    <h4 class="fw-bold mb-0" style="color: <?= $laba_color; ?>;">
                        Rp <?= number_format($laba_bersih, 0, ',', '.'); ?>
                    </h4>

                    <small class="text-muted-custom fw-bold text-uppercase"
                        style="font-size: 0.75rem;">
                        Laba Bersih
                    </small>

                </div>
            </div>

            <div class="card border-secondary py-3 text-center h-50 shadow-sm">

                <div class="card-body d-flex flex-column justify-content-center">

                    <h4 class="fw-bold mb-0 text-dark-pekat">
                        Rp <?= number_format($laba_kotor, 0, ',', '.'); ?>
                    </h4>

                    <small class="text-muted-custom fw-bold text-uppercase"
                        style="font-size: 0.75rem;">
                        Laba Kotor
                    </small>

                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="card border-red h-100 shadow-sm overflow-hidden">

                <div class="card-header bg-white border-0 py-2">

                    <small class="text-danger fw-bold text-uppercase">
                        <i class="bi bi-wallet2 me-2"></i>
                        Rincian Pengeluaran
                    </small>

                </div>

                <div class="card-body d-flex flex-column justify-content-center pt-0">

                    <h2 class="fw-bold mb-3" style="color: #DC2626;">
                        Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?>
                    </h2>

                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted-custom small fw-bold text-uppercase">
                            Operasional
                        </span>

                        <span class="fw-bold small text-dark-pekat">
                            Rp <?= number_format($biaya_operasional, 0, ',', '.'); ?>
                        </span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted-custom small fw-bold text-uppercase">
                            Gaji Mekanik
                        </span>

                        <span class="fw-bold small text-dark-pekat">
                            Rp <?= number_format($gaji_mekanik, 0, ',', '.'); ?>
                        </span>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-3">

        <div class="col-md-3 text-center">

            <div class="card border-cyan p-3 shadow-sm">

                <small class="text-muted-custom fw-bold d-block mb-1">
                    ASET GUDANG
                </small>

                <h6 class="fw-bold mb-0" style="color: #0EA5E9;">
                    Rp <?= number_format($total_aset_gudang, 0, ',', '.'); ?>
                </h6>

            </div>
        </div>

        <div class="col-md-3 text-center">

            <div class="card border-green p-3 shadow-sm"
                style="border-left: 6px solid #10B981 !important;">

                <small class="text-muted-custom fw-bold d-block text-uppercase">
                    Belanja Stok
                </small>

                <h6 class="fw-bold mb-0" style="color: #10B981;">
                    Rp <?= number_format($pembelian, 0, ',', '.'); ?>
                </h6>

            </div>
        </div>

        <div class="col-md-3 text-center">

            <div class="card border-orange p-3 shadow-sm">

                <small class="text-muted-custom fw-bold d-block text-uppercase">
                    Piutang
                </small>

                <h6 class="fw-bold mb-0" style="color: #F59E0B;">
                    <?= $belum_lunas; ?> Transaksi
                </h6>

            </div>
        </div>

        <div class="col-md-3 text-center">

            <div class="card border-red p-3 shadow-sm">

                <small class="text-muted-custom fw-bold d-block text-uppercase">
                    Stok Kritis
                </small>

                <h6 class="fw-bold mb-0" style="color: #DC2626;">
                    <?= $stok_kritis_count; ?> Item
                </h6>

            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm overflow-hidden">

                <div class="card-header py-3 text-center"
                    style="background-color: #111827;">

                    <h5 class="mb-0 fw-bold text-white text-uppercase">
                        <i class="bi bi-activity me-2 text-warning"></i>
                        STATUS PEKERJAAN MEKANIK
                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="bg-light">

                                <tr class="text-muted-custom small fw-bold">

                                    <th width="150" class="ps-4">
                                        PLAT NOMOR
                                    </th>

                                    <th>MEKANIK</th>

                                    <th>KELUHAN AWAL</th>

                                    <th width="200" class="text-center">
                                        STATUS
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($unit_proses as $up): ?>

                                    <tr>

                                        <td class="ps-4">

                                            <span class="badge bg-dark px-3 py-2 font-monospace"
                                                style="font-size: 0.9rem;">

                                                <?= $up['nomor_plat']; ?>

                                            </span>

                                        </td>

                                        <td class="fw-bold text-dark-pekat">
                                            <?= $up['nama_mekanik'] ?? '-'; ?>
                                        </td>

                                        <td class="text-muted-custom small">
                                            <?= $up['keluhan_awal']; ?>
                                        </td>

                                        <td class="text-center">

                                            <?php
                                            $st = $up['status_pengerjaan'];
                                            $style = "";
                                            $icon = "";
                                            $pulse = "";

                                            switch ($st) {
                                                case 'Antre':
                                                    $style = "background: #F3F4F6; color: #6B7280; border: 1px solid #D1D5DB;";
                                                    $icon = '<i class="bi bi-dot blink-icon fs-5"></i>';
                                                    break;

                                                case 'Diproses':
                                                    $style = "background: #FEF3C7; color: #D97706; border: 1px solid #F59E0B;";
                                                    $icon = '<i class="bi bi-gear-fill spin-icon me-1"></i>';
                                                    $pulse = "status-active-pulse";
                                                    break;

                                                case 'Menunggu Part':
                                                    $style = "background: #FFF7ED; color: #EA580C; border: 1px solid #FB923C;";
                                                    $icon = '<i class="bi bi-hourglass-split tilt-icon me-1"></i>';
                                                    break;

                                                case 'Selesai':
                                                    $style = "background: #DCFCE7; color: #16A34A; border: 1px solid #22C55E;";
                                                    $icon = '<i class="bi bi-check-circle-fill me-1"></i>';
                                                    break;

                                                case 'Dibatalkan':
                                                    $style = "background: #FEE2E2; color: #DC2626; border: 1px solid #EF4444;";
                                                    $icon = '<i class="bi bi-x-circle-fill me-1"></i>';
                                                    break;
                                            }
                                            ?>

                                            <span class="badge rounded-pill px-3 py-2 <?= $pulse ?>"
                                                style="<?= $style ?>">

                                                <?= $icon . $st ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                <?php if (empty($unit_proses)): ?>

                                    <tr>

                                        <td colspan="4"
                                            class="text-center py-5 text-muted fw-bold">

                                            <i class="bi bi-info-circle me-2"></i>

                                            Belum ada motor yang sedang dikerjakan atau mengantre.

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>
    function updateClock() {
        const now = new Date();

        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };

        const clockElement = document.getElementById('live-clock');

        if (clockElement) {
            clockElement.textContent = now.toLocaleTimeString('id-ID', options);
        }
    }

    setInterval(updateClock, 1000);

    updateClock();
</script>

<?= $this->endSection(); ?>