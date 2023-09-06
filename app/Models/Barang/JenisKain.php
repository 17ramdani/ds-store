<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKain extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "jenis_kain";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function tipe_kain()
    {
        return $this->hasMany(TipeKain::class, 'jenis_kain_id', 'id');
    }
}
