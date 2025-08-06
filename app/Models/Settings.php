<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
    protected $fillable = [
        'header_image',
        'primary_image',
        'secondary_image',
        'header_extra',
        'header_title',
        'header_text',
        'primary_title',
        'primary_text',
        'secondary_title',
        'secondary_text',
    ];
}
