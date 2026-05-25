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
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    body.login-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('<?= base_url('assets/background_login.jpeg') ?>') no-repeat center center;
        background-size: cover;
        animation: bgZoom 18s ease-in-out infinite alternate;
        z-index: 0;
    }

    body.login-page::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(2px);
        z-index: 1;
    }

    @keyframes bgZoom {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.06);
        }
    }

    .login-box {
        position: relative;
        z-index: 2;
        width: 400px;
        max-width: 95%;
        animation: fadeUp 0.8s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(35px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-box .card {
        background: rgba(255, 255, 255, 0.94);
        border: none;
        border-radius: 16px;
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.18);
        transition: transform 0.3s ease;
    }

    .login-box .card:hover {
        transform: translateY(-4px);
    }

    .card-header {
        border-bottom: none;
        padding-top: 28px;
        background: transparent;
    }

    .card-header h1 {
        font-weight: 700;
        font-size: 2rem;
        color: #111;
    }

    .login-box-msg {
        color: #666;
        margin-bottom: 22px;
        font-size: 0.95rem;
    }

    .logo-pulse {
        width: 150px;
        margin-bottom: 16px;
        animation: pulseLogo 2s infinite ease-in-out;
    }

    @keyframes pulseLogo {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.08);
        }

        100% {
            transform: scale(1);
        }
    }

    .form-control {
        border-radius: 8px 0 0 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.20);
    }

    .input-group-text {
        border-radius: 0 8px 8px 0;
        transition: all 0.3s ease;
    }

    .form-control:focus+.input-group-text {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .toggle-password {
        cursor: pointer;
        user-select: none;
    }

    .toggle-password:hover {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .btn-primary {
        border-radius: 8px;
        font-weight: 600;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(13, 110, 253, 0.35);
    }

    .btn-primary:disabled {
        opacity: 0.9;
    }

    .shake {
        animation: shake 0.45s;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20% {
            transform: translateX(-8px);
        }

        40% {
            transform: translateX(8px);
        }

        60% {
            transform: translateX(-6px);
        }

        80% {
            transform: translateX(6px);
        }
    }

    .spinner-border {
        vertical-align: middle;
        margin-left: 8px;
    }
    </style>
</head>

<body class="login-page">

    <div class="login-box">

        <div class="card card-outline card-primary <?= session()->getFlashdata('error') ? 'shake' : '' ?>">

            <div class="card-header text-center">

                <img src="<?= base_url('assets/logo.png') ?>" alt="Logo Tri Jaya Motor" class="logo-pulse">

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

                <form action="<?= base_url('auth/login') ?>" method="post" id="loginForm">

                    <!-- Username -->
                    <div class="input-group mb-3">
                        <input type="text" name="nama_pengguna" class="form-control" placeholder="Username" required>

                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="kata_sandi" id="passwordInput" class="form-control"
                            placeholder="Password" required>

                        <div class="input-group-text toggle-password" id="togglePassword">
                            <span class="bi bi-eye" id="eyeIcon"></span>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                                <span id="btnText">Sign In</span>
                                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <script src="<?= base_url('assets/adminlte/js/adminlte.js') ?>"></script>

    <script>
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');

    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';

        passwordInput.setAttribute('type', type);

        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });

    form.addEventListener('submit', function() {
        spinner.classList.remove('d-none');
        btnText.textContent = 'Signing In...';
        btn.disabled = true;
    });
    </script>

</body>

</html>