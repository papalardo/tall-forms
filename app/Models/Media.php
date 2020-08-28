<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'path',
        'disk',
        'dir',
        'name',
        'size',
        'mime_type'
    ];
}
