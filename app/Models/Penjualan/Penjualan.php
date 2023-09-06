<?php

namespace App\Models\Penjualan;

use App\Models\Pesanan\Pesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table    = 'penjualan';
    protected $guarded  = [];

    public function inovice()
    {
        return $this->belongsTo(InvoiceJual::class,'penjualan_id');
    }

    function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }
}
