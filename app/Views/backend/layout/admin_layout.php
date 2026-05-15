<!-- app/Views/backend/layout/admin_layout.php -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul ?? 'Sistem Bengkel'; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?= $this->include('backend/layout/header'); ?>
        <?= $this->include('backend/layout/sidebar'); ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <?= $this->renderSection('content'); ?>
            </div>
        </main>

        <?= $this->include('backend/layout/footer'); ?>
    </div>
    <style>
    :root {
        --lte-sidebar-width: 275px;
    }
    </style>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

    <!-- Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (session()->getFlashdata('error')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: <?= json_encode(session()->getFlashdata('error')); ?>
        });
    });
    </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: <?= json_encode(session()->getFlashdata('success')); ?>
        });
    });
    </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Informasi',
            text: <?= json_encode(session()->getFlashdata('message')); ?>
        });
    });
    </script>
    <?php endif; ?>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>