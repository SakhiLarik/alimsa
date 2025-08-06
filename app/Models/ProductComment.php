<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    //
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'response',
        'is_deleted',
        'deleted_at',
    ];
}
