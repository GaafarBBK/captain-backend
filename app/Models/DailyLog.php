<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    protected $fillable = ['day_date', 'steps','calories'];
    use HasFactory;
}
