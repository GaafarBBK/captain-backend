<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainSubscription extends Model
{
    protected $fillable = ['duration_in_weeks', 'price', 'isAvailable'];
    use HasFactory;

    public function captain(){
        return $this->belongsTo(Captain::class);
    }
}
