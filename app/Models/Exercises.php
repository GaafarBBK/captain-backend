<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    protected $fillable =['name', 'description', 'target_muscle', 'equipment','sets', 'reps' , 'status', 'isPublic'];
    use HasFactory;

    public function workout(){
        return $this->belongsToMany(Workout::class);
    }
}
