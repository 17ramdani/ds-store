<?php

namespace App\Models\Pesanan;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerExperience extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
