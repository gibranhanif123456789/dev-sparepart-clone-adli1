<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'User - Aplikasi Spare Part')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .font-sans {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false, profileOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
            class="fixed inset-y-0 left-0 z-50 w-48 bg-[#001438] text-white shadow-lg flex flex-col transform transition-transform duration-300 md:translate-x-0 md:static md:inset-0"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 border-b border-blue-900 bg-[#002060] px-4">
                <span class="text-lg font-bold">SMS</span>
                <button @click="sidebarOpen = false" class="md:hidden text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu -->
            <nav class="mt-6 px-2 flex-1">
                <a href="{{ route('jenis.barang') }}"
                   class="flex items-center px-3 py-2 rounded transition duration-200 hover:bg-blue-900 text-gray-300 hover:text-white
                          {{ request()->routeIs('jenis.barang') ? 'bg-blue-900 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h8a2 2 0 012 2v2" />
                    </svg>
                    <span>List Sparepart</span>
                </a>

                <a href="{{ route('request.barang.index') }}"
                   class="flex items-center px-3 py-2 mt-2 rounded transition duration-200 hover:bg-blue-900 text-gray-300 hover:text-white
                          {{ request()->routeIs('request.barang.index') ? 'bg-blue-900 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Request Barang</span>
                </a>
            </nav>

            <!-- Profile -->
            <div class="p-3 border-t border-blue-900 relative"
                 x-data="{ showDropdown: false }"
                 @mouseenter="showDropdown = true"
                 @mouseleave="showDropdown = false">
                <!-- Profile Info -->
                <div class="bg-white text-gray-800 rounded-lg p-2 flex items-center space-x-2 text-sm cursor-pointer">
                    <img src="{{ asset('images/avatar.png') }}" alt="Profile" class="w-8 h-8 rounded-full">
                    <div class="truncate ml-2">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-600">User</div>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="showDropdown" x-transition
                     class="absolute bottom-16 left-4 bg-white text-gray-800 rounded-lg shadow-lg w-48 z-50"
                     x-cloak>
                    <!-- Trigger Modal -->
                    <button @click="profileOpen = true"
                       class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                        Profil Saya
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay saat sidebar terbuka (mobile) -->
        <div
            x-show="sidebarOpen"
            class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40"
            @click="sidebarOpen = false">
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 relative">
            <!-- Tombol Hamburger (hanya muncul di mobile) -->
            <button
                @click="sidebarOpen = true"
                class="md:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2 rounded-md shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="p-6">
                @yield('content')
            </div>
        </main>

        <!-- Modal Profil User -->
        <div x-show="profileOpen" x-transition
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
             x-cloak
             @click.self="profileOpen = false">
            <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
                <!-- Tombol Close -->
                <button @click="profileOpen = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    ✕
                </button>

                <h2 class="text-xl font-bold mb-4 text-gray-800">Profil User</h2>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><span class="font-semibold">Nama:</span> {{ Auth::user()->name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</p>
                    <p><span class="font-semibold">Role:</span>
                        @php
                            $roles = ['1' => 'Admin', '2' => 'Kepala RO', '3' => 'Kepala Gudang', '4' => 'Field Technician'];
                        @endphp
                        {{ $roles[Auth::user()->role] ?? Auth::user()->role }}
                    </p>
                    <p><span class="font-semibold">Regional Office:</span> {{ Auth::user()->region }}</p>
                    <p><span class="font-semibold">Atasan:</span> {{ Auth::user()->atasan }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
