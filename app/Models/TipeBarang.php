<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeBarang extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'jenis',
        'kategori',
];

    protected $table = 'tipe_barang';

    public function listBarang()
    {
        return $this->hasMany(ListBarang::class, 'jenis_id');
    }
}
