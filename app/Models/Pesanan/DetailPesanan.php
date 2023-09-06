<?php

namespace App\Models\Pesanan;

use App\Models\Barang\Barang;
use App\Models\Barang\TipeKain;
use App\Models\Barang\Warna;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPesanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "detail_pesanan";
    protected $primaryKey  = "id";
    protected $guarded = [];

    function tipe_kain()
    {
        return $this->belongsTo(TipeKain::class,'tipe_kain_id','id');
    }

    function warna_pesanan(){
        return $this->belongsTo(Warna::class,'warna_id','id');
    }
}
