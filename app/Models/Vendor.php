<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    public $timestamps = false;

    protected $fillable = ['nama_vendor'];
}