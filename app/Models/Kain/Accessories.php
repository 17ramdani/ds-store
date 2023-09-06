<?php

namespace App\Models\Kain;

use App\Models\Pesanan\DetailPesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessories extends Model
{
    use HasFactory, SoftDeletes;

    function details()
    {
        return $this->hasMany(DetailPesanan::class, 'tipe_kain_id', 'id');
    }
}
