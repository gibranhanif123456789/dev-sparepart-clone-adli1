<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Sparepart PGN.COM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        /* .hero {
            background: url('https://images.unsplash.com/photo-1620714223084-8fcacc6dfd8d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(8px);
            padding: 6rem 0;
        } */

        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid #e0e6ed;
            border-top-width: 4px;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #4e73df;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-jenis {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        .btn-jenis:hover {
            background-color: #3a56c4;
            transform: translateY(-2px);
        }

        .btn-request {
            background-color: #1cc88a;
            border-color: #1cc88a;
            color: white;
        }

        .btn-request:hover {
            background-color: #17a673;
            transform: translateY(-2px);
        }

        .logo {
            height: 60px;
        }

        .footer {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="antialiased">
    <div class="hero flex items-center">
        <div class="max-w-5xl mx-auto w-full px-6 py-12 text-center">
            

            <!-- Judul -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Sistem Manajemen Sparepart             </h1>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4"><span class="text-blue-700">Field Technician</span> </h1>
            <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
               Akses Data, Request, dan Monitoring Sparepart </p>
            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-4xl mx-auto">
                <!-- Jenis Barang -->
                <a href="{{ route('jenis.barang') }}"
                   class="bg-white rounded-xl shadow-lg p-8 text-left border-l-4 border-transparent 
            hover:border-blue-500 hover:shadow-2xl transform hover:-translate-y-1 
            transition-all duration-300 ease-in-out cursor-pointer">
                    <div class="flex items-center mb-5">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-blue-600 transition">
                            <i class="fas fa-cogs text-xl text-blue-600 group-hover:text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Daftar Barang</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Lihat daftar semua jenis sparepart yang tersedia di sistem.</p>
                    <span class="btn-custom btn-jenis">Lihat Daftar <i class="fas fa-arrow-right"></i></span>
                </a>

                <!-- Request Barang -->
                <a href="{{ route('request.barang.index') }}"
                  class="bg-white rounded-xl shadow-lg p-8 text-left border-l-4
            hover:border-green-500 hover:shadow-4xl transform hover:-translate-y-1 
            transition-all duration-300 ease-in-out cursor-pointer">
                    <div class="flex items-center mb-5">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-green-600 transition">
                            <i class="fas fa-clipboard-list text-xl text-green-600 group-hover:text-white"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Request Barang</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Ajukan permintaan sparepart dengan cepat dan tercatat.</p>
                    <span class="btn-custom btn-request">Buat Request <i class="fas fa-plus"></i></span>
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-16 footer">
                <p>&copy; {{ date('Y') }} Aplikasi Sparepart - PT PGN.COM. Solusi Digital untuk Operasional Unggul.</p>
            </div>
        </div>
    </div>
</body>
</html>