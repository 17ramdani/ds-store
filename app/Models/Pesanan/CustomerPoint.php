<?php

namespace App\Models\Pesanan;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPoint extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
    function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
