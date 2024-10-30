<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    protected $fillable = ['user_id','day_date', 'steps','calories'];
    use HasFactory;

    public function athlete(){
        return $this->belongsTo(User::class);
    }
}
