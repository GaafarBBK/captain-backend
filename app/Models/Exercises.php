<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Set;

class Exercises extends Model
{
    protected $fillable =['name', 'description', 'target_muscle', 'equipment', 'status', 'isPublic'];
    use HasFactory;

    public function workout(){
        return $this->belongsToMany(Workout::class);
    }

    public function sets(){
        return $this->hasMany(Set::class);
    }
}
