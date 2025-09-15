<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.home');
    }

    public function jenisBarang(Request $request)
{
    $kategori = $request->get('kategori');
    $query = JenisBarang::query();

    if ($kategori) {
        $query->where('kategori', $kategori);
    }

    $jenisBarang = $query->with('listBarang')->get();
    return view('user.jenisbarang', compact('jenisBarang'));
}
}