<?php

namespace App\Models;

use App\Models\Barang\Barang;
use App\Models\Barang\Warna;
use App\Models\Barang\TipeKain;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keranjang extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    function tipe_kain()
    {
        return $this->belongsTo(TipeKain::class, 'tipe_kain_id', 'id');
    }

    function warna_pesanan()
    {
        return $this->belongsTo(Warna::class, 'warna_id', 'id');
    }

    function accesories()
    {
        return $this->belongsTo(TipeKain::class, 'accesories_id', 'id');
    }
}
