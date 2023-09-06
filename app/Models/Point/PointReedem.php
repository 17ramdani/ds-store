<?php

namespace App\Models\Point;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointReedem extends Model
{
    use HasFactory;
    protected $table = 'redeem_points';
    protected $guarded = ['id'];
}
