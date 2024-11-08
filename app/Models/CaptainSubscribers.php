<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainSubscribers extends Model
{
    protected $fillable = ['user_id','captain_id','isActive', 'start_date', 'end_date'];
    use HasFactory;

    public function captain(){
        return $this->belongsTo(Captain::class);
    }
}
