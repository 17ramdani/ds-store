<?php

namespace App\Models\Barang;

use App\Models\Customer\CustomerCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKainPrices extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tipe_kain_prices";
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    function customer()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id', 'id');
    }
}
