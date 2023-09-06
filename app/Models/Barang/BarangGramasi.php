<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangGramasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "barang_gramasi";
    protected $primary_key = "id";
    protected $guarded = [];
}
