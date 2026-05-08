<!-- app/Views/backend/layout/header.php -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tri Jaya Motor | <?= $title ?? 'Dashboard'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Font & Bootstrap Icons[cite: 2] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

    <!-- Third Party Plugin (OverlayScrollbars)[cite: 2] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />

    <!-- AdminLTE 4 CSS[cite: 2, 4] -->
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
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link">
                    <span class="d-none d-md-inline">Halo, <b><?= session()->get('nama_pengguna'); ?></b></span>
                </a>
            </li>
        </ul>
    </div>
</nav>