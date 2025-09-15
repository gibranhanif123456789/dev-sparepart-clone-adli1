@extends('layouts.user')

@section('title', 'Daftar Jenis Barang')

@section('content')
<div class="py-8 px-6">
    <!-- Filter -->
    <div class="mb-6 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="filter-kategori" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">Semua</option>
                <option value="aset" {{ request('kategori') == 'aset' ? 'selected' : '' }}>Aset</option>
                <option value="non-aset" {{ request('kategori') == 'non-aset' ? 'selected' : '' }}>Non-Aset</option>
            </select>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jenisBarang as $index => $jenis)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $jenis->jenis }}</td>

                            <!-- Kolom Kategori -->
                            <td class="px-6 py-4 text-sm">
                                <span class="
                                    px-2 py-1 text-xs font-medium rounded-full
                                    {{ $jenis->kategori === 'aset' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}
                                ">
                                    {{ ucfirst($jenis->kategori) }}
                                </span>
                            </td>

                            <!-- Kolom Status -->
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $jumlah = $jenis->listBarang->sum('quantity');
                                @endphp
                                <span class="
                                    px-2 py-1 text-xs font-medium rounded-full
                                    {{ $jumlah > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                ">
                                    {{ $jumlah > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                <i class="fas fa-inbox fa-2x text-gray-400 block mb-2"></i>
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script untuk Filter -->
<script>
    document.getElementById('filter-kategori').addEventListener('change', function () {
        const kategori = this.value;
        const url = new URL(window.location.href.split('?')[0], window.location.origin);
        
        if (kategori) {
            url.searchParams.set('kategori', kategori);
        } else {
            url.searchParams.delete('kategori');
        }
        
        window.location.href = url.toString();
    });
</script>
@endsection