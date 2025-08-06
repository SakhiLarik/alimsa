<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    //
    protected $fillable = [
        'product_id',
        'location',
        'is_deleted',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
