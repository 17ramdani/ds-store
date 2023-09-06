<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BayarJual extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $guarded = [];
    function invoice_jual()
    {
        return $this->belongsTo(InvoiceJual::class);
    }
}
