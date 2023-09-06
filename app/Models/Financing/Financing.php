<?php

namespace App\Models\Financing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Financing extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = "financing";
    protected $primaryKey = "id";

    protected $guarded  = [];
    // protected $fillable = [
    //     'customer_id',
    //     'pesanan_id',
    //     'tgl_pengajuan',
    //     'nominal',
    //     'status'
    // ];

}
