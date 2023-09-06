<?php

namespace App\Models\Penjualan;

use App\Models\Pesanan\Pesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceJual extends Model
{
    use HasFactory, SoftDeletes;
    protected $table    = 'invoice_juals';
    protected $guarded  = [];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class,'no_invoice','no_invoice');
    }
}
