<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tri Jaya Motor | Log in</title>

    <!-- Google Font & Icons[cite: 2] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.css') ?>">
</head>

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="mb-0"><b>Tri Jaya</b> Motor</h1>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk untuk mengelola bengkel</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger p-2 small">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/login') ?>" method="post">
                    <!-- Input Username[cite: 1, 6] -->
                    <div class="input-group mb-3">
                        <input type="text" name="nama_pengguna" class="form-control" placeholder="Username" required>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                    <!-- Input Password[cite: 1, 6] -->
                    <div class="input-group mb-3">
                        <input type="password" name="kata_sandi" class="form-control" placeholder="Password" required>
                        <div class="input-group-text">
                            <span class="bi bi-lock"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/adminlte/js/adminlte.js') ?>"></script>
</body>

</html>