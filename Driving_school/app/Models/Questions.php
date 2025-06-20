<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';
    
    protected $fillable = [
        'numero',
        'question', 
        'reponses',
        'bonne_reponse'
    ];

    public $timestamps = false;

    public function getReponsesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setReponsesAttribute($value)
    {
        $this->attributes['reponses'] = json_encode($value);
    }

    public function isCorrectAnswer($userAnswer)
    {
        return strtolower($userAnswer) === strtolower($this->bonne_reponse);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('numero');
    }
}