<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutritions extends Model
{
    protected $fillable = ['date', 'total_protein', 'total_carbs', 'total_calories', 'notes'];
    use HasFactory;
}
