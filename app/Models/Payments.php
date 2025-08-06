<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $fillable = [
        'user_id',
        'order_id',
        'payable',
        'paid',
        'payment_method',
        'account',
        'account_title',
        'account_number',
        'transaction_id',
        'screenshot',
        'payment_successfull',
        'order_completed',
    ];
}
