<?php

namespace App\Models\Point;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPointReedem extends Model
{
    use HasFactory;
    protected $table = 'redeem_point_details';
    protected $guarded = ['id'];
}
