<?php
$peran = session()->get('peran');
$bolehNotifBisnis = in_array($peran, ['Admin', 'Pemilik']);
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
            $stok_kritis = $stok_kritis_count ?? 0;
$piutang = $belum_lunas ?? 0;
?>

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true,
            showCloseButton: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        const sudahMuncul = sessionStorage.getItem('notif_pop_up');

        <?php if ($bolehNotifBisnis && ($stok_kritis > 0 || $piutang > 0)): ?>
        if (!sudahMuncul) {
            Toast.fire({
                icon: 'warning',
                title: 'Pemberitahuan Sistem',
                html: `
                    <div style="font-size: 0.85rem; text-align: left;">
                        <?php if ($stok_kritis > 0): ?>
                            <i class="bi bi-box-seam text-danger"></i>
                            <b><?= $stok_kritis ?></b> stok kritis<br>
                        <?php endif; ?>

                        <?php if ($piutang > 0): ?>
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <b><?= $piutang ?></b> belum lunas
                        <?php endif; ?>

                        <hr class="my-2">

                        <a href="<?= base_url('master/sparepart'); ?>"
                           class="btn btn-xs btn-primary text-white w-100"
                           style="font-size: 0.75rem;">
                            Lihat Detail Sparepart
                        </a>
                    </div>
                `
            });

            sessionStorage.setItem('notif_pop_up', 'true');
        }
        <?php endif; ?>
    });
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tri Jaya Motor | <?= $title ?? 'Dashboard'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.css') ?>" />
</head>

<nav class="app-header navbar navbar-expand bg-body shadow-sm">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">

            <?php if ($bolehNotifBisnis): ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>

                    <?php if (isset($total_notif) && $total_notif > 0): ?>
                    <span class="navbar-badge badge text-bg-danger fw-bold">
                        <?= $total_notif; ?>
                    </span>
                    <?php endif; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0">
                    <span class="dropdown-item dropdown-header fw-bold">
                        Pemberitahuan
                    </span>

                    <div class="dropdown-divider"></div>

                    <?php if (isset($stok_kritis_count) && $stok_kritis_count > 0): ?>
                    <a href="<?= base_url('master/sparepart'); ?>" class="dropdown-item">
                        <i class="bi bi-box-seam me-2 text-danger"></i>
                        <?= $stok_kritis_count; ?> Item Stok Kritis
                    </a>
                    <?php endif; ?>

                    <?php if (isset($belum_lunas) && $belum_lunas > 0): ?>
                    <a href="<?= base_url('transaksi/servis'); ?>" class="dropdown-item">
                        <i class="bi bi-exclamation-circle me-2 text-warning"></i>
                        <?= $belum_lunas; ?> Transaksi Belum Lunas
                    </a>
                    <?php endif; ?>

                    <?php if (!isset($total_notif) || $total_notif == 0): ?>
                    <div class="dropdown-item text-center text-muted small py-3">
                        Tidak ada masalah stok atau tagihan.
                    </div>
                    <?php endif; ?>

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item dropdown-footer text-center">
                        Tandai sudah dibaca
                    </a>
                </div>
            </li>
            <?php endif; ?>

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link">
                    <span class="d-none d-md-inline">
                        Halo, <b><?= session()->get('nama_pengguna'); ?></b>
                    </span>
                </a>
            </li>

        </ul>
    </div>
</nav>