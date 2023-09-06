<?php

namespace App\Models\Barang;

use App\Models\Keranjang;
use App\Models\Pesanan\DetailPesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKain extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tipe_kain";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function prices()
    {
        return $this->hasMany(TipeKainPrices::class, 'tipe_kain_id', 'id');
    }

    function tipekainacs()
    {
        return $this->hasMany(TipeKainAccessories::class, 'tipe_kain_id');
    }

    function lebar()
    {
        return $this->belongsTo(BarangLebar::class, 'barang_lebar_id', 'id');
    }
    function gramasi()
    {
        return $this->belongsTo(BarangGramasi::class, 'barang_gramasi_id', 'id');
    }
    function kategoriwarna()
    {
        return $this->belongsTo(Warna::class, 'kategori_warna_id', 'id');
    }
    function warna()
    {
        return $this->belongsTo(Warna::class, 'warna_id', 'id');
    }
    function satuan()
    {
        return $this->belongsTo(BarangSatuan::class, 'barang_satuan_id', 'id');
    }
    function jenis_kain()
    {
        return $this->belongsTo(JenisKain::class, 'jenis_kain_id', 'id');
    }

    function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'tipe_kain_id', 'id');
    }

    function detail_pesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'tipe_kain_id', 'id');
    }
}
