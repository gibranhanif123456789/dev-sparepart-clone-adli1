<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\KepalaGudangController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KepalaROController;

require __DIR__ . '/auth.php';

// =====================
// DEFAULT ROUTE
// =====================
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

// =====================
// AUTH
// =====================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// =====================
// PROFILE (all roles)
// =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

// =====================
// SUPERADMIN (role:1)
// =====================
Route::middleware(['auth', 'role:1'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->controller(SuperadminController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/request', 'requestIndex')->name('request.index');
        Route::get('/sparepart', 'sparepartIndex')->name('sparepart.index');
        Route::get('/sparepart/{tiket_sparepart}/detail', 'showDetail')->name('sparepart.detail');
        Route::get('/history', 'historyIndex')->name('history.index');
    });

// =====================
// KEPALA RO (role:2)
// =====================
Route::middleware(['auth', 'role:2'])
    ->prefix('kepalaro')
    ->name('kepalaro.')
    ->controller(KepalaROController::class)
    ->group(function () {
        Route::get('/home', fn() => view('kepalaro.home'))->name('home');
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/history', 'history')->name('history');
        Route::post('/approve/{id}', 'approve')->name('approve');
        Route::post('/reject/{id}', 'reject')->name('reject');

        Route::get('/api/pending-count', 'pendingCount')->name('api.pending.count');
    });

// =====================
// KEPALA GUDANG (role:3)
// =====================
Route::middleware(['auth', 'role:3'])
    ->prefix('kepalagudang')
    ->name('kepalagudang.')
    ->controller(KepalaGudangController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/request', 'requestIndex')->name('request.index');
        Route::post('/request/store', 'requestStore')->name('request.store');

        Route::post('/sparepart/store', [SparepartController::class, 'store'])->name('sparepart.store');
        Route::get('/sparepart', [SparepartController::class, 'index'])->name('sparepart.index');
        Route::get('/sparepart/{tiket_sparepart}/detail', [SparepartController::class, 'showDetail'])->name('sparepart.detail');

        Route::get('/history', 'historyIndex')->name('history.index');
        Route::get('/history/{id}', 'historyDetail')->name('history.detail');
        Route::get('/profile', fn() => view('kepalagudang.profile'))->name('profile');
    });

// =====================
// USER (role:4)
// =====================
Route::middleware(['auth', 'role:4'])
    ->prefix('user')
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/jenisbarang', [HomeController::class, 'jenisBarang'])->name('jenis.barang');
    });

// =====================
// REQUEST BARANG (all authenticated users)
// =====================
Route::prefix('requestbarang')
    ->name('request.barang.')
    ->controller(PermintaanController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{tiket}', 'getDetail')->name('detail');
        Route::post('/', 'store')->name('store');

        // 🔥 API: Detail Status Approval Berjenjang
        Route::get('/api/permintaan/{tiket}/status', function ($tiket) {
            $permintaan = \App\Models\Permintaan::where('tiket', $tiket)->firstOrFail();

            return response()->json([
                'ro' => $permintaan->status_ro,
                'gudang' => $permintaan->status_gudang,
                'admin' => $permintaan->status_admin,
                'super_admin' => $permintaan->status_super_admin,
                'catatan' => collect([
                    $permintaan->catatan_ro,
                    $permintaan->catatan_gudang,
                    $permintaan->catatan_admin,
                    $permintaan->catatan_super_admin,
                ])->filter()->first(),
            ]);
        })->name('api.permintaan.status');

        // API: Ambil jenis barang berdasarkan kategori
        Route::get('/api/jenis-barang', function (\Illuminate\Http\Request $request) {
            $kategori = $request->query('kategori');
            $query = \App\Models\JenisBarang::query();

            if ($kategori) {
                $query->where('kategori', $kategori);
            }

            return response()->json(
                $query->orderBy('jenis')->get(['id', 'jenis as nama']) // <-- di sini: as nama
            );
        })->name('api.jenis.barang');

        // API: Ambil tipe barang berdasarkan kategori
       Route::get('/api/tipe-barang', function (\Illuminate\Http\Request $request) {
    $kategori = $request->query('kategori');
    $jenisId = $request->query('jenis_id');

    $query = \App\Models\TipeBarang::query();

    // Filter berdasarkan kategori
    if ($kategori) {
        $query->where('kategori', $kategori);
    }

    // Filter berdasarkan relasi ke jenis_barang melalui detail_barang
    if ($jenisId) {
        $query->whereHas('detailBarangs', function ($q) use ($jenisId) {
            $q->where('jenis_id', $jenisId);
        });
    }

    return response()->json(
        $query->orderBy('tipe')->get(['id', 'tipe as nama'])
    );
})->name('api.tipe.barang');
    });