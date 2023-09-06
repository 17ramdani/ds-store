<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAdress extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'customer_address';
    protected $primaryKey = 'id';
}
