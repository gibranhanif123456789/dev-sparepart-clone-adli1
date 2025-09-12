<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kepala Gudang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- CSS Sidebar & Dashboard --}}
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 280px;
            --header-height: 70px;
            --card-border-radius: 12px;
            --sidebar-bg: #2c3e50;
            --sidebar-color: #ecf0f1;
            --sidebar-active: #3498db;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            min-height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header h4 {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            color: white;
        }

        .sidebar-header h4 i {
            font-size: 1.8rem;
            margin-right: 10px;
        }

        .sidebar .list-group-item {
            background: transparent;
            color: var(--sidebar-color);
            border: none;
            border-left: 4px solid transparent;
            border-radius: 0;
            padding: 1rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--sidebar-active);
        }

        .sidebar .list-group-item.active {
            background: linear-gradient(90deg, rgba(52, 152, 219, 0.2), transparent);
            border-left-color: var(--sidebar-active);
            color: white;
        }

        .sidebar .list-group-item i {
            width: 24px;
            margin-right: 12px;
            transition: all 0.3s;
        }

        .sidebar .list-group-item.active i {
            transform: scale(1.1);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .stats-title {
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0;
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            height: 100%;
        }

        .table-container h5 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.2rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
            border-bottom: 2px solid #f0f0f0;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        /* Date Badge */
        .badge-date {
            background: linear-gradient(45deg, var(--primary), var(--info));
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
            color: white;
        }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        /* Pagination Container */
        .pagination-container {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1rem 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Button Export */
        .btn-export {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            transition: all 0.3s;
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: var(--card-border-radius);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            border-top-left-radius: var(--card-border-radius);
            border-top-right-radius: var(--card-border-radius);
        }

        /* Nav Tabs */
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 0.75rem 1rem;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary);
            background: transparent;
            border-bottom: 3px solid var(--primary);
        }

        /* Toggle Button for Mobile */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                text-align: center;
            }

            .sidebar-header h4 span,
            .sidebar .list-group-item span,
            .user-details {
                display: none;
            }

            .sidebar .list-group-item i {
                margin-right: 0;
                font-size: 1.3rem;
            }

            .sidebar-header h4 i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            .user-avatar {
                margin-right: 0;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-toggle {
                display: flex;
            }
        }

        /* Animation for cards */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Additional improvements */
        .card-icon.bg-primary {
            background-color: rgba(67, 97, 238, 0.1) !important;
        }

        .card-icon.bg-danger {
            background-color: rgba(230, 57, 70, 0.1) !important;
        }

        .card-icon.bg-success {
            background-color: rgba(76, 201, 240, 0.1) !important;
        }

        .card-icon.bg-warning {
            background-color: rgba(247, 37, 133, 0.1) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-danger {
            background-color: var(--danger) !important;
        }

        .bg-success {
            background-color: var(--success) !important;
        }

        .bg-warning {
            background-color: var(--warning) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-danger {
            color: var(--danger) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        .text-warning {
            color: var(--warning) !important;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar Toggle Button for Mobile -->
    <button class="sidebar-toggle d-flex align-items-center justify-content-center">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header p-3">
            <h4 class="text-white"><i class="bi bi-archive-fill"></i> <span>Kepala Gudang</span></h4>
        </div>
        <div class="list-group list-group-flush flex-grow-1">
            <a href="{{ route('kepalagudang.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kepalagudang.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('kepalagudang.request.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kepalagudang.request.index') ? 'active' : '' }}">
                <i class="bi bi-send"></i> <span>Request / Send</span>
            </a>
            <a href="{{ route('kepalagudang.sparepart.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kepalagudang.sparepart.index') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kepalagudang.history.index') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> <span>Histori Barang</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('profile.index') }}" class="d-flex align-items-center text-decoration-none text-white">
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="user-details">
                    <p class="user-name mb-0">{{ Auth::user()->name ?? 'Kepala Gudang' }}</p>
                    <small class="user-role">Kepala Gudang</small>
                </div>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.sidebar-toggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Update date dynamically (if needed in child pages)
        function updateDate() {
            const now = new Date();
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            const dateElement = document.getElementById('current-date');
            if (dateElement) {
                dateElement.textContent = formattedDate;
            }
        }

        // Initial call
        updateDate();
    </script>
    @stack('scripts')
</body>

</html>