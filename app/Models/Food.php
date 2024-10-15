<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = ['name', 'quantity', 'calories', 'portion', 'carbs', 'protein', 'isPublic'];
    use HasFactory;
}
