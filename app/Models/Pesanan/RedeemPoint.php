<?php

namespace App\Models\Pesanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedeemPoint extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
