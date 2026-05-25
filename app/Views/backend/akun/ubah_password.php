<form action="<?= base_url('akun/ubah-password'); ?>" method="post">
    <?= csrf_field(); ?>

    <div class="mb-3">
        <label>Password Lama</label>
        <input type="password" name="password_lama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" name="password_baru" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasi_password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">
        Ubah Password
    </button>
</form>