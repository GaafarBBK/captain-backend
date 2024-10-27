<?php

namespace App\Models;

use App\Models\Exercises;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = ['user_id','captain_id','title', 'date','status'];
    use HasFactory;

    public function exercises(){
        return $this->belongsToMany(Exercises::class);
    }   

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function captain(){
        return $this->belongsTo(Captain::class);
    }
}
