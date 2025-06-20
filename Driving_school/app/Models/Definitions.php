<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Definitions extends Model
{
    protected $table = 'definitions';

    protected $fillable = [
        'terme',
        'definition',
    ];

    public $timestamps = false;
}
