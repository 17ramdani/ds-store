<?php

namespace App\Models\Pesanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesMan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "salesman";
    protected $primaryKey  = "id";
    protected $guarded = [];
}
