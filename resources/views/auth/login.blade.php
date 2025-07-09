<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - VEDIKA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('assets/img/backgrounds/logos.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(135deg, #5a67d8, #805ad5, #f687b3);
        background-size: 400% 400%;
        animation: gradient 12s ease infinite;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .login-card {
        background: #ffffffcc;
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 2rem;
        width: 100%;
        max-width: 360px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .login-card .logo {
        max-width: 100px;
        display: block;
        margin: 0 auto 1.2rem;
    }

    .login-title {
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .login-subtitle {
        text-align: center;
        color: #718096;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .form-floating .form-control {
        border-radius: 12px;
        background: #fdfdfd;
        border: 1px solid #e2e8f0;
    }

    .form-floating .form-control:focus {
        border-color: #5a67d8;
        box-shadow: 0 0 0 0.15rem rgba(90, 103, 216, 0.25);
    }

    .btn-login {
        background: linear-gradient(135deg, #5a67d8, #805ad5);
        color: #fff;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #6b73ff, #9e5fff);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(90, 103, 216, 0.3);
    }

    .btn-login.loading {
        pointer-events: none;
        position: relative;
    }

    .btn-login.loading::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        top: 50%;
        left: 50%;
        margin-left: -9px;
        margin-top: -9px;
        border: 2px solid transparent;
        border-top: 2px solid #ffffff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .alert-danger {
        background: #ffe6e6;
        color: #c53030;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        font-size: 0.875rem;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 1.5rem;
            max-width: 95%;
        }

        .login-title {
            font-size: 1.3rem;
        }

        .login-subtitle {
            font-size: 0.875rem;
        }

        .btn-login {
            font-size: 0.9rem;
        }
    }
</style>

</head>

<body>
    <div class="login-card">
        <img src="{{ asset('assets/img/backgrounds/logos.png') }}" alt="Logo Rumah Sakit" class="logo">
        <p class="login-subtitle">Silakan masuk ke sistem VEDIKA</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
            action="{{ \Illuminate\Support\Facades\Route::has('login.attempt') ? route('login.attempt') : url('/login') }}"
            id="loginForm">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="identity" id="identity" class="form-control" placeholder="Username"
                    value="{{ old('identity') }}" required autofocus>
                <label for="identity"><i class="fas fa-user me-2"></i>Username</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                    required>
                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
            </div>

            <button type="submit" class="btn btn-login w-100" id="loginBtn">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
            </button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.innerHTML = '<span>Memproses...</span>';
        });
    </script>
</body>

</html>
