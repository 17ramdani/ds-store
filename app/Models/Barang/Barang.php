<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "barang";
    protected $primaryKey = "id";
    protected $guarded = [];

    function lebar()
    {
        return $this->belongsTo(BarangLebar::class, 'barang_lebar_id', 'id');
    }
    function gramasi()
    {
        return $this->belongsTo(BarangGramasi::class, 'barang_gramasi_id', 'id');
    }
    function warna()
    {
        return $this->belongsTo(Warna::class, 'warna_id', 'id');
    }
    function satuan()
    {
        return $this->belongsTo(BarangSatuan::class, 'barang_satuan_id', 'id');
    }
}
