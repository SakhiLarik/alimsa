<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    //
    protected $fillable = [
        'product_id',
        'user_id',
        'ratings',
        'review',
        'is_deleted'
    ];
}
