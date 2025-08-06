<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOnFeature extends Model
{
    //
    protected $fillable = [
        'product',
        'name',
        'price',
        'image',
    ];
}
