<?php

namespace App\Models\Whitelist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang\TipeKain;

class Whitelist extends Model
{
    use HasFactory;
    protected $table = "whitelist";
    protected $guarded  = ['id'];

    function tipe_kain()
    {
        return $this->belongsTo(TipeKain::class, 'tipe_kain_id', 'id');
    }
}
