<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Aplikasi RO</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   <style>
    body {
        font-family: 'Inter', sans-serif;
        background-image: url('/images/login-bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        overflow: hidden;
    }
    .header {
        background: #002060;
        color: white;
        text-align: center;
        padding: 20px;
        border-bottom: 1px solid #00A0E3;
    }
    .btn-primary {
        background: #002060;
        hover:bg: #001440;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4">

    <!-- Container Utama -->
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">

        <!-- Header PGN -->
        <div class="bg-[#002060] text-white py-6 px-8 text-center">
            <div class="flex items-center justify-center space-x-3">
              
                <h1 class="text-2xl font-bold">SiSparepart</h1>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#ffff]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8v8M8 12h8"/>
                </svg>
            </div>
            <p class="text-sm text-[#ffff] mt-1">Sistem Manajemen Sparepart PT.PGN COM</p>
        </div>

        <!-- Form Login -->
        <div class="p-8 space-y-6">
            <h2 class="text-xl font-semibold text-gray-800 text-center">Masuk ke Akun Anda</h2>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-4 py-3 rounded-lg input-field shadow-sm transition"
                            placeholder="contoh@pgn.co.id"
                        />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 rounded-lg input-field shadow-sm transition"
                            placeholder="••••••••"
                        />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#002060] focus:ring-[#00A0E3]">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-[#002060] hover:text-[#001440] font-medium">Lupa password?</a>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 mt-6 rounded-lg btn-primary font-semibold text-lg shadow-md transform transition hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00A0E3]">
                    MASUK
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-100">
            <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} PT PGN COM. Hak Cipta Dilindungi.
            </p>

        </div>
    </div>
</body>
</html>