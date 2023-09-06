<?php

namespace App\Models\Barang;

use App\Models\Kain\Accessories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKainAccessories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tipe_kain_accessories";
    protected $guarded = [];

    function accessories(){
        return $this->belongsTo(Accessories::class, 'accessories_id', 'id');
    }

    function tipekainpriceecer(){
        return $this->belongsTo(TipeKainPrices::class , 'tipe_kain_id','tipe_kain_id');
    }

    function tipekainpriceroll(){
        return $this->belongsTo(TipeKainPrices::class , 'tipe_kain_id','tipe_kain_id');
    }

    function kain(){
        return $this->belongsTo(TipeKain::class, 'tipe_kain_id', 'id');
    }
}
