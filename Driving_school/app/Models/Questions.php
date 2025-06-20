<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'numero',
        'question',
        'image',
        'chapitre',
    ];

    public $timestamps = false;
}
