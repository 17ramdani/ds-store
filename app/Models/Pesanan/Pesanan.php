<?php

namespace App\Models\Pesanan;

use App\Models\Customer\Customer;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Penjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "pesanan";
    protected $primaryKey  = "id";
    protected $guarded = [];

    function detailgroupby()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    function status()
    {
        return $this->belongsTo(StatusPesanan::class, 'status_pesanan_id', 'id');
    }
    function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    function details()
    {
        return $this->hasMany(DetailPesanan::class);
    }
    function sales_man()
    {
        return $this->belongsTo(SalesMan::class, 'sales_man_id', 'id');
    }

    function invoice()
    {
        return $this->belongsTo(InvoiceJual::class, 'no_invoice');
    }

    function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'costumer_id');
    }

    function komplain()
    {
        return $this->hasOne(Komplain::class, 'pesanan_id', 'id');
    }
}
