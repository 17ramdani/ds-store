<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "customer";
    protected $primaryKey = "id";

    protected $fillable = [
        'customer_category_id',
        'nama',
        'email',
        'nama_perusahaan',
        'alamat',
        'kota',
        'agama',
        'jenis_kelamin',
        'pob',
        'dob',
        'nohp',
        'notlp',
        'omset',
        'npwp',
        'no_ktp',
        'lama_berusaha',
        'alamat_perusahaan',
        'tlp_perusahaan',
        'email_perusahaan',
        'jenis_usaha',
        'omset_perusahaan',
        'kebutuhan_nominal',
        'referensi',
        'file_ktp'
    ];

  //  protected $guarded = [];

    function customer_category()
    {
        return $this->belongsTo(CustomerCategory::class);
    }
}
