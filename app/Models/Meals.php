<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    protected $fillable = ['name', 'meal_protein', 'meal_carbs', 'meal_calories'];
    use HasFactory;

    public function nutrition(){
        return $this->belongsTo(Nutritions::class);
    }

    public function food(){
        return $this->hasMany(Food::class);
    }
}
