    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light d-flex align-items-center justify-content-center vh-100">

        <div class="card shadow p-4" style="min-width: 350px;">
            <h1 class="text-center mb-4">Login</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('login.attempt') ? route('login.attempt') : url('/login') }}">
                @csrf
                <div class="mb-3">
                    <label for="identity" class="form-label">Username</label>
                    <input type="text" name="identity" id="identity" class="form-control" value="{{ old('identity') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>

    </body>
    </html>
