<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tri Jaya Motor | Log in</title>

    <!-- Google Font & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.css') ?>">

    <style>
        body.login-page {
            position: relative;
            min-height: 100vh;
            background: url('<?= base_url('assets/background_login.jpeg') ?>') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }

        body.login-page::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.5);
            z-index: 0;
        }

        .login-box {
            position: relative;
            z-index: 1;
        }

        .login-box .card {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-bottom: none;
            padding-top: 25px;
        }

        .card-header h1 {
            font-weight: 700;
            font-size: 2rem;
            color: #111;
        }

        .login-box-msg {
            color: #666;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 6px;
        }

        .input-group-text {
            border-radius: 0 6px 6px 0;
        }

        .btn-primary {
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>

<body class="login-page">

    <div class="login-box">

        <div class="card card-outline card-primary">

            <div class="card-header text-center">

                <!-- Logo -->
                <img src="<?= base_url('assets/logo.png') ?>" alt="Logo Tri Jaya Motor" width="150" class="mb-3">

                <!-- Title -->
                <h1 class="mb-0">
                    <b>Tri Jaya</b> Motor
                </h1>

            </div>

            <div class="card-body login-card-body">

                <p class="login-box-msg">
                    Masuk untuk mengelola bengkel
                </p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger p-2 small">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/login') ?>" method="post">

                    <!-- Username -->
                    <div class="input-group mb-3">

                        <input type="text" name="nama_pengguna" class="form-control" placeholder="Username" required>

                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>

                    </div>

                    <div class="input-group mb-3">

                        <input type="password" name="kata_sandi" class="form-control" placeholder="Password" required>

                        <div class="input-group-text">
                            <span class="bi bi-lock"></span>
                        </div>

                    </div>

                    <!-- Button -->
                    <div class="row">
                        <div class="col-12">

                            <button type="submit" class="btn btn-primary w-100">
                                Sign In
                            </button>

                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

    k
    <script src="<?= base_url('assets/adminlte/js/adminlte.js') ?>"></script>

</body>

</html>