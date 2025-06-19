<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Vadika</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-[#121212] text-gray-800 dark:text-gray-200 font-sans flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-2xl text-center">
        <h1 class="text-4xl font-bold mb-4 text-[#1b1b18] dark:text-white">Welcome to <span class="text-blue-600">Vadika</span></h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
            Sistem Informasi Manajemen untuk Pengelolaan Data yang Optimal
        </p>

        @if (Route::has('login'))
            <div class="flex justify-center gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="px-6 py-2 border rounded-md text-sm font-medium transition hover:bg-gray-100 dark:hover:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="px-6 py-2 border rounded-md text-sm font-medium transition hover:bg-gray-100 dark:hover:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="px-6 py-2 border rounded-md text-sm font-medium transition hover:bg-blue-100 dark:hover:bg-blue-900 border-blue-600 text-blue-600 dark:text-blue-400"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

</body>
</html>
