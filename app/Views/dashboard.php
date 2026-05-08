<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- Small box contoh AdminLTE -->
        <div class="small-box text-bg-primary p-3 rounded shadow-sm">
            <div class="inner">
                <h3>Dashboard</h3>
                <p>Selamat Datang, <?= session()->get('nama_pengguna'); ?>!</p>
            </div>
            <div class="icon">
                <i class="bi bi-speedometer"></i>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>