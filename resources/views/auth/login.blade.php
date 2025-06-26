<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - VEDIKA </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png"> --}}
    <link rel="icon" href="{{ asset('assets/img/backgrounds/logos.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #34495e;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --light-bg: rgba(255, 255, 255, 0.95);
            --shadow-light: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            position: relative;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 2px, transparent 2px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: var(--light-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            max-width: 480px;
            width: 100%;
            box-shadow: var(--shadow-heavy);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--success-color), var(--primary-color), #9b59b6);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { background-position: -200% 0; }
            50% { background-position: 200% 0; }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .hospital-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .hospital-logo {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--success-color), #2ecc71);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 12px 40px rgba(39, 174, 96, 0.3);
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .hospital-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            animation: logoShine 3s infinite;
        }

        @keyframes logoShine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        }

        .hospital-logo:hover {
            transform: translateY(-4px) scale(1.05);
        }

        .hospital-logo i {
            font-size: 2.2rem;
            color: white;
            z-index: 2;
            position: relative;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .login-subtitle {
            color: #7f8c8d;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0;
        }

        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 1.625rem 1rem 0.625rem;
            height: auto;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: var(--shadow-light);
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating > label {
            color: #6c757d;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #6c757d;
            font-size: 1.1rem;
            padding: 0;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), #3a6cb8);
            color: white;
            font-weight: 600;
            border-radius: 16px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border: none;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(44, 90, 160, 0.4);
            background: linear-gradient(135deg, #3a6cb8, var(--primary-color));
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 16px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            box-shadow: var(--shadow-light);
        }

        .alert-danger {
            background: linear-gradient(135deg, #ffebee, #ffcdd2);
            color: var(--danger-color);
        }

        .alert-danger i {
            color: var(--danger-color);
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
                border-radius: 20px;
            }
            
            .login-title {
                font-size: 1.6rem;
            }
            
            .hospital-logo {
                width: 70px;
                height: 70px;
            }
            
            .hospital-logo i {
                font-size: 1.8rem;
            }
        }

        .btn-login.loading {
            pointer-events: none;
            position: relative;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .medical-pattern {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            color: rgba(44, 90, 160, 0.1);
        }

        .welcome-text {
            background: linear-gradient(135deg, var(--primary-color), #3a6cb8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="card login-card">
            <div class="medical-pattern">
                <i class="fas fa-heartbeat"></i>
            </div>

            <div class="hospital-header">
                <!-- Logo rumah sakit -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/backgrounds/logos.png') }}" 
                     alt="Logo Rumah Sakit" 
                     class="img-fluid"
                     {{-- style="max-width: 140px; height: auto; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);" --}}
                     >
            </div>
                <h1 class="login-title">
                    <span class="welcome-text">Selamat Datang</span>
                </h1>
                
            </div>

            

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('login.attempt') ? route('login.attempt') : url('/login') }}" id="loginForm">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" 
                           name="identity" 
                           id="identity" 
                           class="form-control" 
                           placeholder="Masukkan username Anda"
                           value="{{ old('identity') }}" 
                           required 
                           autofocus>
                    <label for="identity">
                        <i class="fas fa-user me-2"></i>Username
                    </label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control" 
                           placeholder="Masukkan password Anda"
                           required>
                    <label for="password">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk ke Sistem
                    </button>
                </div>
            </form>

            {{-- <!-- Footer info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>
                    Sistem aman dan terpercaya
                </small>
            </div> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading animation for login button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.innerHTML = '<span>Memproses...</span>';
        });

        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>

</body>
</html>