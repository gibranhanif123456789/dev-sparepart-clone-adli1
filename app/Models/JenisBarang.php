<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table = 'jenis_barang';
    public $timestamps = false;

    protected $fillable = ['jenis', 'kategori'];

    public function listBarang()
    {
        return $this->hasMany(ListBarang::class, 'jenis_id');
    }

    public function detailBarangs()  // ✅ Ditambahkan
    {
        return $this->hasMany(DetailBarang::class, 'jenis_id');
    }
}