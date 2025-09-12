<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Sparepart PGN.COM - Kepala RO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            margin: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .hero {
            width: 100%;
            max-width: 800px;
            text-align: center;
            padding: 2rem 0;
        }

        .card-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid #e0e6ed;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            text-align: center;
            max-width: 400px;
            width: 100%;
            border-top: 4px solid #1cc88a;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #1cc88a;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-top: 1.5rem;
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
            height: 70px;
            margin-bottom: 2rem;
        }

        .footer {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 4rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #3b82f6;
            margin-bottom: 1.5rem;
        }

        p {
            color: #6b7280;
            line-height: 1.6;
        }

        .card-icon {
            font-size: 3rem;
            color: #1cc88a;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .card-description {
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .card-hover {
                padding: 2rem;
            }
        }
    </style>
</head>
<body class="antialiased">
    <div class="hero">
        <!-- Logo -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Logo_PGN_New.png/320px-Logo_PGN_New.png" alt="PGN Logo" class="logo">

        <!-- Judul -->
        <h1>Sistem Manajemen Sparepart</h1>
        <h2>Kepala Regional Office</h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
            Monitoring dan Persetujuan Request Sparepart Operasional
        </p>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Single Card -->
            <div class="card-hover">
                <div class="card-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="card-title">Dashboard Request</h3>
                <p class="card-description">
                    Lihat, pantau, dan setujui permintaan sparepart dari Field Technician.
                </p>
                <a href="{{ route('kepalaro.dashboard') }}" class="btn-custom btn-request">
                    Show Request <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Aplikasi Sparepart - PT PGN. Solusi Digital untuk Operasional Unggul.</p>
        </div>
    </div>
</body>
</html>