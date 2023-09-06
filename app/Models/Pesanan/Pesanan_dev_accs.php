<?php

namespace App\Models\Pesanan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan_dev_accs extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
}
