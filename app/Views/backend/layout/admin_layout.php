<!-- app/Views/backend/layout/admin_layout.php -->
<!doctype html>
<html lang="en">


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <?= $this->include('backend/layout/header'); ?>
        <?= $this->include('backend/layout/sidebar'); ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <!-- Bagian Konten Dinamis -->
                <?= $this->renderSection('content'); ?> <!--[cite: 2] -->
            </div>
        </main>

        <?= $this->include('backend/layout/footer'); ?>

    </div>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>