<?php

namespace App\Models\Point;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;
    protected $table = "customer_points";

    public function cust()
    {
        return $this->belongsTo(customer::class, "id");
    }
}
