<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    //
    protected $fillable = [
        'product_id',
        'name',
        'symbol',
        'price',
        'image',
        'is_deleted',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at'
    ];
}
