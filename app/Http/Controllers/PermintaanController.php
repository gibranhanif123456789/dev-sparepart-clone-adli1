<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    /**
     * Tampilkan list permintaan user yang sedang login
     */
   public function index(Request $request)
{
    $query = Permintaan::with(['user', 'details'])
        ->where('user_id', Auth::id());

    // Filter berdasarkan status
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_permintaan', [
            $request->start_date,
            $request->end_date
        ]);
    }

    $permintaans = $query->orderBy('tanggal_permintaan', 'desc')->get();

    return view('user.requestbarang', compact('permintaans'));
}

    /**
     * Simpan permintaan baru
     */
   public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array|min:1',
        'items.*.nama' => 'required|string|max:50',
        'items.*.deskripsi' => 'required|string|max:255',
        'items.*.jumlah' => 'required|integer|min:1',
        'items.*.keterangan' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    // Tiket otomatis dibuat oleh model
    $permintaan = Permintaan::create([
        'user_id'            => $user->id,
        'tanggal_permintaan' => now(),
        'status'             => 'pending',
    ]);

    foreach ($request->items as $item) {
        $permintaan->details()->create([
            'tiket'      => $permintaan->tiket,
            'nama_item'  => $item['nama'],
            'deskripsi'  => $item['deskripsi'],
            'jumlah'     => $item['jumlah'],
            'keterangan' => $item['keterangan'] ?? null,
        ]);
    }

    return redirect()->route('request.barang.index')->with('success', 'Permintaan berhasil dikirim!');
}

    /**
     * Ambil detail permintaan berdasarkan tiket (API)
     */
    public function getDetail($tiket)
    {
        $permintaan = Permintaan::with(['details', 'user'])
            ->where('tiket', $tiket)
            ->firstOrFail();

        return response()->json([
            'tiket'              => $permintaan->tiket,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'name'               => $permintaan->user->name,
            'details'            => $permintaan->details->map(function ($detail) {
                return [
                    'nama'       => $detail->nama_item,
                    'deskripsi'  => $detail->deskripsi ?? '-',
                    'jumlah'     => $detail->jumlah,
                    'keterangan' => $detail->keterangan ?? '-',
                ];
            }),
        ]);
    }
    /**
 * Ambil status approval per tahap
 */
public function getStatus($tiket)
{
    $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();

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
}
}
