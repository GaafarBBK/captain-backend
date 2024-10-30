<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exercises;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'exercises_id',
        'set_no',
        'reps',
        'weight',
        'status',
    ];

    public function exercise(){
        return $this->belongsTo(Exercises::class);
    }

    public function workout(){
        return $this->belongsTo(Workout::class);
    }
}
