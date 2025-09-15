@extends('layouts.user')

@section('title', 'Request Barang')

@section('content')
<div class="container py-5 px-6">

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg text-sm flex items-center">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="ms-auto" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Filter -->
    <form method="GET" action="{{ route('request.barang.index') }}" class="mb-4 flex flex-wrap gap-3 items-end">
        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <!-- Range Tanggal -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Dari</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Sampai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        <!-- Tombol Filter -->
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
        </div>
    </form>

    <!-- Default: Tampilkan History -->
    <div id="history-section" class="bg-white shadow rounded-lg p-6 max-w-5xl mx-auto">
        <h4 class="text-xl font-bold mb-4 flex items-center text-gray-800">
            <i class="fas fa-history me-2 text-blue-600"></i> History Request
        </h4>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Tiket</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permintaans as $index => $p)
                        <tr class="ticket-row hover:bg-gray-50 cursor-pointer transition-colors">
                            <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-blue-600">{{ $p->tiket }}</td>
                            <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_permintaan)->translatedFormat('l, d F Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-2">
                                    <!-- Status Badge -->
                                    @if ($p->status === 'diterima')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Diterima</span>
                                    @elseif ($p->status === 'ditolak')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Ditolak</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @endif

                                    <!-- Ikon Mata untuk Detail Approval -->
                                    <button 
                                        type="button"
                                        onclick="showStatusDetailModal('{{ $p->tiket }}', 'user')"
                                        class="text-blue-600 hover:text-blue-800 focus:outline-none"
                                        title="Lihat detail progres approval">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button onclick="showDetail('{{ $p->tiket }}')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                <i class="fas fa-inbox fa-3x text-gray-400 block mb-3"></i>
                                <p>Belum ada history request</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Buat Request Baru -->
        <div class="flex justify-end mt-6">
            <button onclick="showForm()" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center transition-all duration-200">
                <i class="fas fa-plus-circle me-2"></i> Buat Request Baru
            </button>
        </div>
    </div>

    <!-- Form Request - Sembunyi awalnya -->
    <div id="form-section" class="bg-white shadow rounded-lg p-6 max-w-5xl mx-auto hidden">
        <h4 class="text-xl font-bold mb-4 flex items-center text-gray-800">
            <i class="fas fa-file-alt me-2 text-blue-600"></i> Form Request Barang
        </h4>

        <form id="request-form" action="{{ route('request.barang.store') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Nama Item</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Deskripsi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="request-table-body">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Kolom No -->
                            <td class="px-4 py-3 text-sm text-center border border-gray-300 bg-gray-50 font-mono">1</td>

                            <!-- Kolom Kategori -->
                            <td class="border border-gray-300">
                                <select name="items[0][kategori]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="aset">Aset</option>
                                    <option value="non-aset">Non-Aset</option>
                                </select>
                            </td>

                            <!-- Kolom Nama Item -->
                            <td class="border border-gray-300">
                                <select name="items[0][nama]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih Item</option>
                                </select>
                            </td>

                            <!-- Kolom Deskripsi -->
                            <td class="border border-gray-300">
                                <select name="items[0][deskripsi]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih Tipe</option>
                                </select>
                            </td>

                            <!-- Kolom Jumlah -->
                            <td class="border border-gray-300">
                                <input type="number" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[0][jumlah]" min="1" value="1" required>
                            </td>

                            <!-- Kolom Keterangan -->
                            <td class="border border-gray-300">
                                <input type="text" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[0][keterangan]" required>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="px-4 py-3 text-center border border-gray-300">
                                <button type="button" class="btn btn-sm btn-danger opacity-50 cursor-not-allowed" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol: Tambah Baris di kiri, Batal & Kirim di kanan -->
            <div class="flex justify-between items-center mt-6">
                <!-- Kiri: Tombol Tambah Baris -->
                <button type="button" onclick="tambahRow()" class="btn btn-outline-primary bg-blue-600 hover:bg-blue-700 text-white border border-blue-600 px-4 py-2 rounded-md text-sm flex items-center transition-all duration-200">
                    <i class="fas fa-plus me-2"></i> Tambah Baris
                </button>

                <!-- Kanan: Batal & Kirim -->
                <div class="flex gap-2">
                    <button type="button" onclick="cancelForm()" class="btn btn-secondary bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-md text-sm transition-all duration-200">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-all duration-200">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Request
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Detail -->
    <div x-data="{ showDetail: false }" x-show="showDetail" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-black bg-opacity-50 absolute inset-0" @click="showDetail = false"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 z-10">
                <div class="modal-header bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h5 class="text-lg font-semibold">Detail Request</h5>
                    <button @click="showDetail = false" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div id="modal-spinner" class="flex justify-center">
                        <div class="spinner-border text-blue-600" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="modal-content" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <strong>Nama Tiket:</strong> <span id="modal-ticket-name"></span>
                            </div>
                            <div>
                                <strong>Tanggal:</strong> <span id="modal-ticket-date"></span>
                            </div>
                            <div>
                                <strong>User:</strong> <span id="modal-ticket-user"></span>
                            </div>
                            <div>
                                <strong>Jumlah Item:</strong> <span id="modal-ticket-count"></span>
                            </div>
                        </div>
                        <h6 class="mt-4 mb-3 font-semibold">Daftar Barang:</h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border-b text-left">No</th>
                                        <th class="px-4 py-2 border-b text-left">Nama Item</th>
                                        <th class="px-4 py-2 border-b text-left">Deskripsi</th>
                                        <th class="px-4 py-2 border-b text-left">Jumlah</th>
                                        <th class="px-4 py-2 border-b text-left">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end">
                    <button onclick="closeDetailModal()" class="btn btn-secondary bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Approval Berjenjang -->
    <div x-data="{ showStatusDetail: false, status: {}, role: 'user' }"
         x-show="showStatusDetail"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         id="status-detail-modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-black bg-opacity-50 absolute inset-0" @click="showStatusDetail = false"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 z-10">
                <div class="modal-header bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h5 class="text-lg font-semibold">Detail Progres Approval</h5>
                    <button @click="showStatusDetail = false" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-sm">
                        <!-- Kepala RO -->
                        <template x-if="['user'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Kepala RO</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.ro === 'pending',
                                    'bg-green-100 text-green-800': status.ro === 'approved',
                                    'bg-red-100 text-red-800': status.ro === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.ro === 'pending'">Pending</template>
                                    <template x-if="status.ro === 'approved'">Disetujui</template>
                                    <template x-if="status.ro === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Kepala Gudang -->
                        <template x-if="['user', 'kepala_ro'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Kepala Gudang</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.gudang === 'pending',
                                    'bg-green-100 text-green-800': status.gudang === 'approved',
                                    'bg-red-100 text-red-800': status.gudang === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.gudang === 'pending'">Pending</template>
                                    <template x-if="status.gudang === 'approved'">Disetujui</template>
                                    <template x-if="status.gudang === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Admin -->
                        <template x-if="['user', 'kepala_ro', 'kepala_gudang'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Admin</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.admin === 'pending',
                                    'bg-green-100 text-green-800': status.admin === 'approved',
                                    'bg-red-100 text-red-800': status.admin === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.admin === 'pending'">Pending</template>
                                    <template x-if="status.admin === 'approved'">Disetujui</template>
                                    <template x-if="status.admin === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Super Admin -->
                        <template x-if="['user', 'kepala_ro', 'kepala_gudang', 'admin'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Super Admin</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.super_admin === 'pending',
                                    'bg-green-100 text-green-800': status.super_admin === 'approved',
                                    'bg-red-100 text-red-800': status.super_admin === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.super_admin === 'pending'">Pending</template>
                                    <template x-if="status.super_admin === 'approved'">Disetujui</template>
                                    <template x-if="status.super_admin === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Catatan Jika Ditolak -->
                        <div class="mt-4 text-sm" x-show="status.catatan">
                            <strong>Catatan:</strong>
                            <p x-text="status.catatan" class="text-gray-600 mt-1"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end">
                    <button @click="showStatusDetail = false" class="btn btn-secondary bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let noRow = 1;

        function showForm() {
            document.getElementById('history-section').classList.add('hidden');
            document.getElementById('form-section').classList.remove('hidden');
        }

        // Inisialisasi dropdown pada baris pertama saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            const firstRow = document.querySelector('#request-table-body tr');
            if (!firstRow) return;

            const selectKategori = firstRow.querySelector('select[name*="[kategori]"]');
            const selectNama = firstRow.querySelector('select[name*="[nama]"]');
            const selectTipe = firstRow.querySelector('select[name*="[deskripsi]"]');

            // Pastikan elemen ada
            if (selectKategori && selectNama && selectTipe) {
                // Pasang event listener agar reaktif saat ganti kategori
                selectKategori.addEventListener('change', () => {
                    loadItemsByKategori(selectKategori, selectNama);
                    loadTipeByKategoriAndJenis(selectKategori, selectNama, selectTipe);
                });

                selectNama.addEventListener('change', () => {
                    loadTipeByKategoriAndJenis(selectKategori, selectNama, selectTipe);
                });

                // Isi dropdown saat halaman dimuat jika kategori sudah dipilih
                if (selectKategori.value) {
                    loadItemsByKategori(selectKategori, selectNama);
                }
            }
        });

        function closeDetailModal() {
            const modal = document.getElementById('detail-modal') || document.querySelector('[x-show="showDetail"]');
            if (modal) {
                modal.style.display = 'none';
            }
            const alpineEl = document.querySelector('[x-data]');
            if (alpineEl && alpineEl.__x) {
                alpineEl.__x.$data.showDetail = false;
            }
        }

        // Load nama item berdasarkan kategori
        async function loadItemsByKategori(selectKategori, targetSelect) {
            const kategori = selectKategori.value;
            if (!kategori) return;

            try {
                const response = await fetch(`/requestbarang/api/jenis-barang?kategori=${kategori}`);
                const items = await response.json();

                targetSelect.innerHTML = '<option value="">Pilih Item</option>';
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; // Simpan ID untuk ambil tipe nanti
                    option.textContent = item.nama;
                    targetSelect.appendChild(option);
                });
            } catch (err) {
                console.error('Gagal muat daftar barang:', err);
                targetSelect.innerHTML = '<option value="">Gagal muat data</option>';
            }
        }

        // Load tipe/deskripsi berdasarkan kategori DAN jenis_id
        async function loadTipeByKategoriAndJenis(selectKategori, selectJenis, targetSelect) {
            const kategori = selectKategori.value;
            const jenisId = selectJenis.value; // ambil dari <select nama>

            if (!kategori || !jenisId) {
                targetSelect.innerHTML = '<option value="">Pilih Tipe</option>';
                return;
            }

            try {
                const response = await fetch(`/requestbarang/api/tipe-barang?kategori=${kategori}&jenis_id=${jenisId}`);
                const tipes = await response.json();

                targetSelect.innerHTML = '<option value="">Pilih Tipe</option>';
                tipes.forEach(tipe => {
                    const option = document.createElement('option');
                    option.value = tipe.nama;
                    option.textContent = tipe.nama;
                    targetSelect.appendChild(option);
                });
            } catch (err) {
                console.error('Gagal muat daftar tipe:', err);
                targetSelect.innerHTML = '<option value="">Gagal muat data</option>';
            }
        }

        function tambahRow() {
            noRow++;
            const tbody = document.getElementById('request-table-body');
            const row = document.createElement('tr');
            row.classList.add('hover:bg-gray-50', 'transition-colors');

            row.innerHTML = `
                <td class="px-4 py-3 text-sm text-center border border-gray-300 bg-gray-50 font-mono">${noRow}</td>
                <td class="border border-gray-300">
                    <select name="items[${noRow - 1}][kategori]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="aset">Aset</option>
                        <option value="non-aset">Non-Aset</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <select name="items[${noRow - 1}][nama]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Item</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <select name="items[${noRow - 1}][deskripsi]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Tipe</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <input type="number" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[${noRow - 1}][jumlah]" min="1" value="1" required>
                </td>
                <td class="border border-gray-300">
                    <input type="text" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[${noRow - 1}][keterangan]" required>
                </td>
                <td class="px-4 py-3 text-center border border-gray-300">
                    <button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);

            const selectKategori = row.querySelector('select[name*="[kategori]"]');
            const selectNama = row.querySelector('select[name*="[nama]"]');
            const selectTipe = row.querySelector('select[name*="[deskripsi]"]');

            // Saat kategori berubah → isi dropdown "Nama Item"
            selectKategori.addEventListener('change', () => {
                loadItemsByKategori(selectKategori, selectNama);
                // Reset tipe saat kategori berubah
                selectTipe.innerHTML = '<option value="">Pilih Tipe</option>';
            });

            // Saat nama item (jenis) berubah → isi dropdown "Tipe" berdasarkan kategori + jenis
            selectNama.addEventListener('change', () => {
                loadTipeByKategoriAndJenis(selectKategori, selectNama, selectTipe);
            });

            // Muat awal jika perlu
            if (selectKategori.value) {
                loadItemsByKategori(selectKategori, selectNama);
            }
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            const rows = document.querySelectorAll('#request-table-body tr');
            rows.forEach((row, index) => {
                const noCell = row.cells[0];
                if (noCell) {
                    noCell.textContent = index + 1;
                }
            });
            noRow = rows.length;
        }

        function cancelForm() {
            document.getElementById('form-section').classList.add('hidden');
            document.getElementById('history-section').classList.remove('hidden');
            document.getElementById('request-form').reset();

            const tbody = document.getElementById('request-table-body');
            tbody.innerHTML = '';

            const row = document.createElement('tr');
            row.classList.add('hover:bg-gray-50', 'transition-colors');
            row.innerHTML = `
                <td class="px-4 py-3 text-sm text-center border border-gray-300 bg-gray-50 font-mono">1</td>
                <td class="border border-gray-300">
                    <select name="items[0][kategori]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="aset">Aset</option>
                        <option value="non-aset">Non-Aset</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <select name="items[0][nama]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Item</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <select name="items[0][deskripsi]" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Tipe</option>
                    </select>
                </td>
                <td class="border border-gray-300">
                    <input type="number" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[0][jumlah]" min="1" value="1" required>
                </td>
                <td class="border border-gray-300">
                    <input type="text" class="w-full border-0 outline-none px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="items[0][keterangan]" required>
                </td>
                <td class="px-4 py-3 text-center border border-gray-300">
                    <button type="button" class="btn btn-sm btn-danger opacity-50 cursor-not-allowed" disabled>
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);

            const selectKategori = row.querySelector('select[name*="[kategori]"]');
            const selectNama = row.querySelector('select[name*="[nama]"]');
            const selectTipe = row.querySelector('select[name*="[deskripsi]"]');

            selectKategori.addEventListener('change', () => {
                loadItemsByKategori(selectKategori, selectNama);
                loadTipeByKategoriAndJenis(selectKategori, selectNama, selectTipe);
            });

            selectNama.addEventListener('change', () => {
                loadTipeByKategoriAndJenis(selectKategori, selectNama, selectTipe);
            });

            noRow = 1;
        }

        function showStatusDetailModal(tiket, userRole) {
            console.log("Mengambil detail untuk tiket:", tiket);
            fetch(`/requestbarang/api/permintaan/${tiket}/status`)
                .then(response => {
                    if (!response.ok) throw new Error('Not Found');
                    return response.json();
                })
                .then(data => {
                    console.log("Data diterima:", data);
                    const modal = document.querySelector('#status-detail-modal');
                    if (modal && modal.__x) {
                        modal.__x.$data.status = data;
                        modal.__x.$data.role = userRole;
                        modal.__x.$data.showStatusDetail = true;
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert('Gagal muat detail status approval. Cek koneksi atau login ulang.');
                });
        }

        function showDetail(tiket) {
            const modalSpinner = document.getElementById('modal-spinner');
            const modalContent = document.getElementById('modal-content');
            modalSpinner.style.display = 'block';
            modalContent.style.display = 'none';

            const modal = document.querySelector('[x-show="showDetail"]');
            if (modal && modal.style.display === 'none') {
                modal.style.display = 'block';
                setTimeout(() => modal.classList.add('opacity-100'), 10);
            }

            fetch(`/requestbarang/${tiket}`)
                .then(response => {
                    if (!response.ok) throw new Error('Not Found');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modal-ticket-name').textContent = data.tiket;
                    document.getElementById('modal-ticket-date').textContent = new Date(data.tanggal_permintaan)
                        .toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    document.getElementById('modal-ticket-user').textContent = data.name || '-';
                    document.getElementById('modal-ticket-count').textContent = data.details.length;

                    const itemsList = document.getElementById('modal-items-list');
                    itemsList.innerHTML = '';
                    data.details.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-2 border-b text-center">${index + 1}</td>
                            <td class="px-4 py-2 border-b">${item.nama}</td>
                            <td class="px-4 py-2 border-b">${item.deskripsi || '-'}</td>
                            <td class="px-4 py-2 border-b text-center">${item.jumlah}</td>
                            <td class="px-4 py-2 border-b">${item.keterangan || '-'}</td>
                        `;
                        itemsList.appendChild(row);
                    });

                    modalSpinner.style.display = 'none';
                    modalContent.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalSpinner.style.display = 'none';
                    modalContent.innerHTML = `
                        <div class="text-center text-red-600 p-4">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Detail tidak ditemukan atau terjadi kesalahan.</p>
                        </div>
                    `;
                    modalContent.style.display = 'block';
                });
        }
    </script>
@endsection