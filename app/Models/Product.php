<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'product_id',
        'category',
        'sub_category',
        'is_perfume',
        'name',
        'size',
        'symbol',
        'image',
        'price',
        'color',
        'febric',
        'design',
        'season',
        'occasion',
        'gender',
        'availability',
        'outfit',
        'description',
        'remarks',
        'is_deleted',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
