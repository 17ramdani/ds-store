<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer\Customer;


class Membership extends Model
{
    use HasFactory;
    protected $table = "membership";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}
