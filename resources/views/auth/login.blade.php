<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('materio/assets/img/backgrounds/enako.jpg');
            background-size: cover;
            background-position: center;materio/
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            min-width: 400px;
            max-width: 450px;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        
        .login-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .floating-label {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            background: white;
            padding: 0 8px;
            color: #6c757d;
            transition: all 0.3s ease;
            pointer-events: none;
            border-radius: 4px;
        }
        
        .form-control:focus + .floating-label,
        .form-control:valid + .floating-label {
            top: 0;
            font-size: 0.85rem;
            color: #4a90e2;
            font-weight: 600;
        }
        
        @media (max-width: 480px) {
            .login-card {
                min-width: 90%;
                margin: 1rem;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
        }
        
        /* Animation untuk card muncul */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            animation: slideInUp 0.6s ease-out;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card login-card shadow p-5">
        <h1 class="text-center login-title">Selamat Datang</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('login.attempt') ? route('login.attempt') : url('/login') }}">
            @csrf
            
            <div class="input-group">
                <input type="text" name="identity" id="identity" class="form-control" value="{{ old('identity') }}" required>
                <label for="identity" class="floating-label">Username</label>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <label for="password" class="floating-label">Password</label>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                Masuk
            </button>
            
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Floating label functionality
        document.querySelectorAll('.form-control').forEach(input => {
            // Check if input has value on page load
            if (input.value) {
                input.classList.add('has-value');
            }
            
            input.addEventListener('input', function() {
                if (this.value) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>

</body>
</html>