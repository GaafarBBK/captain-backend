<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercisesWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'workout_id'
    ];
}
