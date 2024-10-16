<?php

namespace App\Models;

use App\Models\Exercises;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = ['title', 'date','status'];
    use HasFactory;

    public function exercises(){
        return $this->hasMany(Exercises ::class);
    }   
}
