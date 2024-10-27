<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exercises;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'set_no',
        'reps',
        'weight',
        'status',
    ];

    public function exercise(){
        return $this->belongsTo(Exercises::class);
    }
}
