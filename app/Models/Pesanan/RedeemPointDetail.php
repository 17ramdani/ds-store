<?php

namespace App\Models\Pesanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedeemPointDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    function redeem_point()
    {
        return $this->belongsTo(RedeemPoint::class);
    }
    function voucher_point()
    {
        return $this->belongsTo(VoucherPoint::class);
    }
}
