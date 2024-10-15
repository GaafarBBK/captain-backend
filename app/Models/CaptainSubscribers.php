<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainSubscribers extends Model
{
    protected $fillable = ['isActive', 'start_date', 'end_date'];
    use HasFactory;
}
