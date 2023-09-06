<?php

namespace App\Models\Barang;

use App\Models\Pesanan\DetailPesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warna extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "warna";
    protected $primary_key = "id";
    protected $guarded = [];

    function tipe_kain()
    {
        return $this->belongsTo(TipeKain::class,'warna_id');
    }

    function detail_pesanan()
    {
        return $this->belongsTo(DetailPesanan::class,'warna_id','id');
    }
}
