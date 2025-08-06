<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    protected $fillable = [
        'category_id',
        'name',
        'sub_category',
        'description',
        'remarks',
        'is_deleted',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at'
    ];
}
