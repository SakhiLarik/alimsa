<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'product_size_id',
        'user_id',
        'add_on_added',
        'add_on_size',
        'add_on_price',
        'order_amount',
        'price',
        'total_price',
        'is_active',
        'is_paid',
        'is_shipped',
        'is_delivered',
        'is_completed',
        'recieving_address',
        'payment_id',
        'tracking_id',
        'service',
        'is_deleted',
        'deleted_at'
    ];
}
