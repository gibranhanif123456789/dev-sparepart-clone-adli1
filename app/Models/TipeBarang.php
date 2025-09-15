<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeBarang extends Model
{
    protected $table = 'tipe_barang';
    public $timestamps = false;

    protected $fillable = [
        'tipe',      // ✅ Diperbaiki dari 'jenis' → 'tipe'
        'kategori'
    ];

    public function listBarangs()
    {
        return $this->hasMany(ListBarang::class, 'tipe_id');
    }

    public function detailBarangs()
    {
        return $this->hasMany(DetailBarang::class, 'tipe_id');
    }
}