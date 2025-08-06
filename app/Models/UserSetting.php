<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    //
    protected $fillable = [
        'user_id',
        'address_1',
        'address_2',
        'payment_method_bank',
        'payment_method_number',
        'payment_method_title',
    ];
}
